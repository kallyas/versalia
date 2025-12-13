# Versalia WordPress Theme

A minimal, typography-first WordPress theme specifically designed for poetry and literary content.

## Description

Versalia prioritizes reading experience, preserving the intentional formatting of verse while providing modern features for poets, publishers, and literary magazines. The theme treats poems as sacred text requiring special formatting consideration.

**Target Users**: Individual poets, poetry collectives, literary magazines, academic poetry journals, translation publishers

## Features

- **Custom Post Type**: Dedicated "Poem" content type with specialized fields
- **Custom Taxonomies**: Collections and Poetry Forms for organization
- **Typography-First Design**: 4 elegant font pairing presets optimized for readability
- **Reading Modes**: Light, Dark, and Sepia modes with localStorage persistence
- **Keyboard Navigation**: Navigate between poems with keyboard shortcuts
- **Mobile-First**: Responsive design optimized for all devices
- **Accessibility**: WCAG 2.1 AA compliant
- **Block Editor Support**: Full Gutenberg integration via theme.json
- **RTL Language Support**: Built-in right-to-left language support
- **Translation Ready**: Fully internationalized with i18n support

## Requirements

- **WordPress**: 6.0 or higher
- **PHP**: 8.0 or higher
- **Node.js**: 18+ (for development only)
- **npm**: Latest version (for development only)

## Installation

### From WordPress Admin

1. Download the theme ZIP file
2. Go to Appearance > Themes in your WordPress admin
3. Click "Add New" then "Upload Theme"
4. Choose the ZIP file and click "Install Now"
5. Click "Activate" to enable the theme

### Manual Installation

1. Download the theme files
2. Upload the `versalia` folder to `/wp-content/themes/`
3. Activate the theme through the WordPress admin panel

### Post-Activation Steps

1. Go to **Settings > Permalinks** and click "Save Changes" to flush rewrite rules
2. Go to **Appearance > Customize** to configure theme options
3. Create your first poem under **Poems > Add New**

## Development

### Setup Development Environment

```bash
# Navigate to theme directory
cd wp-content/themes/versalia

# Install dependencies
npm install

# Start development server
npm run dev
```

### Build for Production

```bash
# Build optimized assets
npm run build
```

### Linting

```bash
# Lint JavaScript
npm run lint:js

# Lint CSS
npm run lint:css

# Lint PHP (requires PHP CodeSniffer)
phpcs --standard=WordPress functions.php inc/*.php
```

## Theme Structure

```
versalia/
├── style.css                 # Main stylesheet with theme header
├── functions.php             # Theme setup and configuration
├── index.php                 # Fallback template
├── header.php                # Site header
├── footer.php                # Site footer
├── single-poem.php           # Single poem template
├── archive-poem.php          # Poem archive template
├── inc/                      # Theme includes
│   ├── theme-setup.php       # Core theme setup
│   ├── custom-post-types.php # Poem custom post type
│   ├── custom-taxonomies.php # Collections & forms
│   ├── template-tags.php     # Template helper functions
│   ├── template-functions.php # Additional functions
│   └── customizer.php        # Customizer settings
├── template-parts/           # Reusable template parts
├── assets/                   # Theme assets
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   └── images/               # Images and icons
├── languages/                # Translation files
└── theme.json                # WordPress block editor config
```

## Usage

### Creating a Poem

1. Go to **Poems > Add New** in the WordPress admin
2. Enter the poem title
3. Add the poem content in the editor
4. Assign **Collections** and **Poetry Forms** taxonomies
5. Add custom fields (optional):
   - Date Written
   - Dedication
   - Epigraph
   - Audio URL
   - Translation info
6. Publish

### Custom Fields

Until Phase 4 (which adds meta boxes with UI), use the Custom Fields panel in the editor to add:

- `poem_date_written` - Date the poem was written
- `poem_dedication` - Dedication text
- `poem_epigraph` - Epigraph or quote
- `poem_epigraph_attribution` - Attribution for epigraph
- `poem_audio_url` - URL to audio recording
- `poem_original_language` - Original language (for translations)
- `poem_translator` - Translator name(s)
- `poem_form_notes` - Notes about poetic form
- `poem_reading_time` - Estimated reading time in minutes

### Keyboard Shortcuts

When viewing a single poem:

- `←` Previous poem
- `→` Next poem
- `H` Home/Archive
- `R` Random poem
- `L` Toggle reading mode (Light/Dark/Sepia)
- `?` Show keyboard shortcuts help

### Customizer Options

Access via **Appearance > Customize**:

- **Typography**: Select from 4 font pairing presets
- **Colors**: Customize colors for each reading mode
- **Layout**: Configure archive view style and layout options

## Browser Support

- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)
- Mobile Safari (iOS 13+)
- Chrome Mobile (Android 90+)

## Changelog

### 1.0.0
- Initial release
- Custom Poem post type
- Collections and Poetry Forms taxonomies
- Basic template hierarchy
- Typography system with 4 font presets
- Reading modes (Light/Dark/Sepia)
- Keyboard navigation
- Mobile-responsive design
- RTL language support
- Gutenberg integration

## Credits

- **Author**: Tumuhirwe Iden
- **Website**: [versalia.tumuhirwe.dev](https://versalia.tumuhirwe.dev)
- **Repository**: [github.com/kallyas/versalia](https://github.com/kallyas/versalia)

## License

Versalia WordPress Theme, Copyright 2024 Tumuhirwe Iden
Versalia is distributed under the terms of the GNU GPL v2 or later.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.

## Support

For issues, questions, or contributions:
- **GitHub Issues**: [github.com/kallyas/versalia/issues](https://github.com/kallyas/versalia/issues)
- **Documentation**: Visit the theme website at [versalia.tumuhirwe.dev](https://versalia.tumuhirwe.dev)

## Roadmap

Future phases will include:
- Custom Gutenberg blocks (Verse, Stanza, Epigraph, Dedication)
- Audio player integration with waveform visualization
- Meta boxes UI for custom fields
- Advanced customizer options
- Multiple archive view styles
- Chapbook page templates
- Performance optimizations
- WordPress.org submission

---

**Enjoy creating beautiful poetry with Versalia!**
