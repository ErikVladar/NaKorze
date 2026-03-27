<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'qr_code_path',
        'name',
        'email',
        'phone',
        'valid_from',
        'valid_until',
        'is_redeemed',
        'redeemed_at',
        'is_verified',
        'verified_at',
        'verified_by',
        'personal_information_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'valid_from' => 'date',
            'valid_until' => 'date',
            'is_redeemed' => 'boolean',
            'redeemed_at' => 'datetime',
            'is_verified' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Get the personal information associated with this coupon.
     */
    public function personalInformation(): BelongsTo
    {
        return $this->belongsTo(PersonalInformation::class);
    }

    /**
     * User who verified this coupon.
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Generate a unique coupon code.
     */
    public static function generateCode(): string
    {
        do {
            $code = 'NAKORZE' . strtoupper(bin2hex(random_bytes(4)));
        } while (static::where('code', $code)->exists());

        return $code;
    }

    /**
     * Check if coupon is valid (not expired and not redeemed).
     */
    public function isValid(): bool
    {
        $today = now()->toDate();

        return !$this->is_redeemed
            && $this->valid_from <= $today
            && $this->valid_until >= $today;
    }

    /**
     * Get QR code data as JSON string.
     */
    public function getQrCodeData(): string
    {
        return json_encode([
            'code' => $this->code,
            'discount' => $this->discount_percent . '%',
            'valid_from' => $this->valid_from->format('Y-m-d'),
            'valid_until' => $this->valid_until->format('Y-m-d'),
            'status' => $this->isValid() ? 'valid' : 'expired',
        ]);
    }

    /**
     * Generate QR code as HTML image tag.
     * Encodes the URL to the coupon view page using the coupon code.
     */
    public function getQrCode(): string
    {
        // Encode the full URL to the coupon view page using the coupon code instead of ID
        $couponUrl = route('coupons.view', $this->code);
        $qrCode = new QrCode($couponUrl);
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        $dataUri = $result->getDataUri();

        return "<img src=\"{$dataUri}\" alt=\"Coupon QR Code\" style=\"width: 250px; height: 250px;\" />";
    }

    /**
     * Generate and save QR code to disk for email attachment.
     * Returns the path to the saved QR code file.
     */
    public function getQrCodePath(): ?string
    {
        return $this->ensureQrCodeSaved();
    }

    /**
     * Ensure QR code image exists on disk and is linked to this coupon.
     * Returns absolute file path when available.
     */
    public function ensureQrCodeSaved(): ?string
    {
        $relativePath = $this->qr_code_path ?: "qr-codes/qr-code-{$this->code}.png";
        $absolutePath = public_path($relativePath);

        if (!file_exists($absolutePath)) {
            $couponUrl = route('coupons.view', $this->code);
            $qrCode = new QrCode($couponUrl);
            $writer = new PngWriter();
            $result = $writer->write($qrCode);

            if (!is_dir(dirname($absolutePath))) {
                mkdir(dirname($absolutePath), 0755, true);
            }

            file_put_contents($absolutePath, $result->getString());
        }

        if (!file_exists($absolutePath)) {
            return null;
        }

        if ($this->qr_code_path !== $relativePath) {
            $this->forceFill(['qr_code_path' => $relativePath])->save();
        }

        return $absolutePath;
    }

    /**
     * Get public URL for persisted QR code image.
     */
    public function getQrCodeUrl(): ?string
    {
        if (! $this->ensureQrCodeSaved()) {
            return null;
        }

        return asset($this->qr_code_path);
    }

    /**
     * Get logo path for email embedding.
     */
    public function getLogoPath(): ?string
    {
        $logoPath = public_path('logo-korza.png');
        return file_exists($logoPath) ? $logoPath : null;
    }
}

