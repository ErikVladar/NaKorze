# Debugging Coupon Views & QR Codes

## Quick Testing Without Phone/QR Scanner

Visit this URL to test all coupon views without needing to scan QR codes:

```
http://localhost:8000/debug/test-coupon-views
```

This page shows:
- All recent coupons
- Direct links to view each coupon
- QR code previews
- The encoded URLs that the QR codes contain

## What Changed

### 1. **New Debug Route**
- Route: `/debug/test-coupon-views`
- View: `resources/views/debug/test-coupon-views.blade.php`
- Shows all recent coupons with direct access to their view pages

### 2. **New Coupon View Route**
- Route: `GET /coupons/{coupon}/view` → `FormController@viewCoupon()`
- Returns different views based on:
  - **Authenticated + Verified**: Green screen (view-verified.blade.php)
  - **Authenticated + Redeemed**: Red screen (view-redeemed.blade.php)
  - **Guest/Not Authenticated**: Info-only screen (view-info.blade.php)

### 3. **QR Code URL Encoding**
- Updated `Coupon::getQrCode()` to encode: `route('coupons.view', $this->id)`
- Instead of JSON data, QR now links directly to the coupon view page

### 4. **New Redeem Functionality**
- New route: `POST /coupons/redeem`
- New action: `DashboardController@redeem()`
- Adds "Redeem" button to dashboard (green button next to Verify)
- Only admins can redeem coupons
- Updates `is_redeemed` and `redeemed_at` fields

### 5. **Dashboard Updates**
- Added redeem button to both desktop table and mobile cards
- Redeem button only shows if coupon is not yet redeemed
- Both verify and redeem buttons now available per coupon

## How to Test the Views

### Method 1: Debug Page (Easiest)
1. Create a coupon by submitting the form at `/formular`
2. Go to `/debug/test-coupon-views`
3. Click "View Coupon Page" for any coupon
4. Test different scenarios:
   - View as guest (log out first)
   - View as authenticated user
   - Redeem a coupon from dashboard, then view it

### Method 2: Manual QR Scan
1. Go to `/coupon/{coupon-id}` (success page)
2. Take a screenshot of the QR code on your phone
3. Scan it with your phone's default camera app
4. It should open the coupon view page

### Method 3: Direct URL Access
Just visit: `http://localhost:8000/coupons/{id}/view`

## Language Strings Added

All new strings are translated to en/de/sk:
- `coupon_verified` - Title when coupon is verified
- `coupon_not_verified` - Title when not yet verified
- `coupon_redeemed` - Title when redeemed
- `coupon_already_used` - Message for redeemed coupons
- `redeemed_at` - Label for redemption timestamp
- `coupon_details` - Title for guest info view
- `login_to_verify` - CTA for unauthenticated users
- `redeem` - Button text for redeem action
- `coupon_redeemed_success` - Success message after redeem
- `coupon_already_redeemed` - Error message if already redeemed

## Views Created

### 1. `resources/views/coupons/view-verified.blade.php`
- Green checkmark badge
- Shows coupon details
- Shows verification status (who verified, when)
- Shows validity status
- Responsive design

### 2. `resources/views/coupons/view-redeemed.blade.php`
- Red X badge
- Shows coupon details
- Shows "Already Redeemed" status
- Shows redemption timestamp
- Warning message about coupon being used

### 3. `resources/views/coupons/view-info.blade.php`
- Blue info badge
- Shows coupon details
- Login/Verify CTA for unauthenticated users
- No action buttons for guests
- Info-only view

## Troubleshooting

### "Route not found" Error
- Make sure you're accessing `/coupons/{id}/view` not `/coupon/`
- Verify the route is `coupons.view` in routes/web.php

### View Not Rendering Correctly
- Check that the coupon ID is valid
- Verify the coupon exists in the database
- Check browser console for any JavaScript errors

### QR Code Not Working
- The QR code encodes the full URL to the coupon view page
- Make sure your app URL in `.env` is correct
- Try viewing the debug page first to test

### Redeem Button Not Showing
- Only authenticated admins see the redeem button
- Make sure you're logged in as an admin user
- Redeemed coupons don't show the redeem button anymore

## Test Cases

1. **Guest User Views Coupon**
   - Should see info-only view
   - Should see login CTA
   - Should NOT see verify/redeem options

2. **Authenticated User Views Verified Coupon**
   - Should see green verified screen
   - Should see who verified it and when
   - Should see validity status

3. **Authenticated User Views Redeemed Coupon**
   - Should see red redeemed screen
   - Should see redemption timestamp
   - Should see warning message

4. **Admin Redeems Coupon from Dashboard**
   - Click green "Redeem" button
   - See success flash message
   - Coupon status changes to redeemed
   - View coupon → see red redeemed screen

5. **QR Scan Workflow**
   - Generate coupon with form
   - Scan QR from success page
   - Opens coupon view in mobile browser
   - Shows correct view based on auth state
