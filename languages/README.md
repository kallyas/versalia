# Versalia Theme Translations

This directory contains translation files for the Versalia WordPress theme.

## Translation Files

- `versalia.pot` - Translation template (generated via WP-CLI or Poedit)
- Language-specific `.po` and `.mo` files

## How to Translate

### Method 1: Using WordPress Admin

1. Install and activate the [Loco Translate](https://wordpress.org/plugins/loco-translate/) plugin
2. Go to **Loco Translate > Themes**
3. Select **Versalia**
4. Click **+ New language**
5. Select your language and start translating

### Method 2: Using Poedit

1. Download and install [Poedit](https://poedit.net/)
2. Open `versalia.pot` in Poedit
3. Create a new translation for your language
4. Save the `.po` and `.mo` files in this directory
5. Name them according to WordPress language codes (e.g., `versalia-fr_FR.po`)

### Method 3: Using WP-CLI

Generate the POT file:

```bash
wp i18n make-pot . languages/versalia.pot --domain=versalia
```

## Language Codes

Common WordPress language codes:

- English (US): `en_US`
- Spanish (Spain): `es_ES`
- French (France): `fr_FR`
- German: `de_DE`
- Italian: `it_IT`
- Portuguese (Brazil): `pt_BR`
- Russian: `ru_RU`
- Japanese: `ja`
- Chinese (Simplified): `zh_CN`
- Arabic: `ar`

## File Naming

Translation files should be named:
- `versalia-{locale}.po` - Portable Object file (editable)
- `versalia-{locale}.mo` - Machine Object file (compiled)

Example for French:
- `versalia-fr_FR.po`
- `versalia-fr_FR.mo`

## Contributing Translations

We welcome translation contributions! To submit a translation:

1. Fork the repository
2. Add your translation files to the `languages/` directory
3. Submit a pull request with a description of the language added

## RTL Language Support

Versalia includes full RTL (Right-to-Left) language support via `rtl.css`. This file automatically loads for RTL languages like:

- Arabic (ar)
- Hebrew (he)
- Persian/Farsi (fa)
- Urdu (ur)

## Text Domain

The theme text domain is: `versalia`

All translatable strings use this text domain.

## Resources

- [WordPress Internationalization](https://developer.wordpress.org/themes/functionality/internationalization/)
- [WordPress Language Codes](https://wpastra.com/docs/complete-list-wordpress-locale-codes/)
- [Poedit Tutorial](https://poedit.net/wordpress)
- [Loco Translate Plugin](https://wordpress.org/plugins/loco-translate/)

## Questions?

For translation-related questions, please [open an issue](https://github.com/kallyas/versalia/issues) on GitHub.
