# Velzon (Creative variant) — Integration Guide

Sumber: /home/uitm/Downloads/Velzon_HTML_v2.3.0/Velzon_HTML_v2.3.0/HTML/dist/creative

## Struktur dalam projek ini

```
public/velzon/assets/        <- Compiled CSS/JS/fonts/images/libs (guna terus dalam Blade)
resources/views/velzon/      <- 184 HTML pages (asas untuk convert ke Blade)
resources/scss/velzon/       <- SCSS source (customize warna/tema, compile guna Vite)
resources/js/velzon/         <- JS source (app.js, layout.js, pages/)
```

## Cara tengok design page (sebelum convert ke Blade)

Buka HTML terus dalam browser (assets dirujuk relatif, jadi jalan terus):

```bash
# Dashboard utama
xdg-open /home/uitm/Downloads/Velzon_HTML_v2.3.0/Velzon_HTML_v2.3.0/HTML/dist/creative/index.html

# Landing page (sesuai utk photography portfolio)
xdg-open .../dist/creative/landing.html

# Login / auth pages
xdg-open .../dist/creative/auth-signin-basic.html
xdg-open .../dist/creative/auth-signup-basic.html

# Layouts (vertical/horizontal/detached)
xdg-open .../dist/creative/layouts-vertical-hovered.html
```

## Page penting untuk projek fotographer

- index.html — dashboard
- landing.html — public/marketing page
- auth-*.html — login/register/reset password
- pages-profile.html, pages-profile-settings.html — profile
- apps-gallery / pages-gallery.html — galeri foto
- tables-datatables.html — senarai data (client/booking)
- forms-*.html — form input
- apps-calendar.html — booking calendar

## Cara integrate ke Blade

1. Pindah asset: public/velzon/assets sudah sedia — rujuk guna `{{ asset('velzon/assets/...') }}`
2. Convert HTML page ke Blade: salin ke resources/views/, tukar `<link href="assets/...">` jadi `{{ asset('velzon/assets/...') }}`
3. SCSS: kalau nak compile guna Vite, import resources/scss/velzon dalam app.scss

## Yang TIDAK dicopy (bukan untuk Laravel)

- Design-Files/ (852M — Figma/PSD design source)
- 7 variant lain (default, saas, material, dll — 1.2G)
- gulpfile.js/package.json (build tool HTML template)
