# Versalia WordPress Theme - Complete Development Specification

## Project Overview
Versalia is a minimal, typography-first WordPress theme specifically designed for poetry and literary content. The theme prioritizes reading experience, preserving the intentional formatting of verse while providing modern features for poets, publishers, and literary magazines.

**Target Users**: Individual poets, poetry collectives, literary magazines, academic poetry journals, translation publishers

**Core Philosophy**: Distraction-free, typography-focused, mobile-first design that treats poems as sacred text requiring special formatting consideration.

---

## Technical Stack & Requirements

### WordPress Standards
- **WordPress Version**: 6.0+ compatibility required
- **PHP Version**: 8.0+ minimum
- **Coding Standards**: Follow WordPress Coding Standards strictly
- **Theme Check**: Must pass WordPress.org theme check
- **Accessibility**: WCAG 2.1 AA compliance minimum
- **Performance**: Page speed score 90+ on mobile/desktop
- **Internationalization**: Full i18n support with text domain 'versalia'

### Frontend Technologies
- **CSS**: Modern CSS with CSS Grid and Flexbox, CSS custom properties for theming
- **JavaScript**: Vanilla ES6+ (minimal jQuery only where necessary for WP compatibility)
- **Build Tools**: Webpack or Vite for asset compilation
- **Fonts**: System fonts with Google Fonts integration option
- **Icons**: SVG-based icon system (no icon fonts)

### WordPress Features
- **Block Editor**: Full Gutenberg support with custom blocks
- **Customizer**: WordPress Customizer API for theme options
- **Navigation Menus**: 2-3 menu locations
- **Widget Areas**: Minimal sidebar options
- **Featured Images**: Optional usage
- **Custom Post Types**: Yes (Poems)
- **Custom Taxonomies**: Collections, Poetry Forms, Themes
- **Theme.json**: Full support for WordPress 5.9+ theme.json

---

## File Structure & Organization

```
versalia/
│
├── style.css                    # Main stylesheet with theme header
├── style.min.css               # Minified production stylesheet
├── rtl.css                     # RTL language support
├── screenshot.png              # 1200x900px theme screenshot
├── functions.php               # Theme setup and configuration
├── index.php                   # Fallback template
├── header.php                  # Site header
├── footer.php                  # Site footer
├── sidebar.php                 # Optional sidebar
├── comments.php                # Comments template (minimal)
├── searchform.php              # Search form template
├── 404.php                     # 404 error page
│
├── single.php                  # Default single post
├── single-poem.php             # Single poem template (primary)
├── page.php                    # Default page template
├── archive.php                 # Default archive
├── archive-poem.php            # Poetry archive (grid/list views)
├── taxonomy-collection.php     # Poetry collection archive
├── taxonomy-poetry-form.php    # Poetry form archive (sonnet, haiku, etc)
├── author.php                  # Author/poet profile page
├── search.php                  # Search results
│
├── page-templates/
│   ├── chapbook.php           # Multi-poem chapbook layout
│   ├── full-width.php         # Full width page (no sidebar)
│   ├── poem-submission.php    # Submission form page
│   └── random-poem.php        # Random poem display
│
├── template-parts/
│   ├── content/
│   │   ├── content-poem.php         # Poem content display
│   │   ├── content-excerpt.php      # Poem excerpt for archives
│   │   ├── content-none.php         # No content found
│   │   └── content-page.php         # Page content
│   ├── header/
│   │   ├── site-branding.php        # Logo/site title area
│   │   └── site-navigation.php      # Main navigation
│   ├── footer/
│   │   ├── footer-widgets.php       # Footer widget area
│   │   └── site-info.php            # Copyright/credits
│   └── poem/
│       ├── poem-meta.php            # Poem metadata (date, form, etc)
│       ├── poem-navigation.php      # Previous/next poem nav
│       ├── poem-audio.php           # Audio player for readings
│       └── author-box.php           # Poet bio box
│
├── inc/
│   ├── theme-setup.php              # Theme setup, support features
│   ├── custom-post-types.php        # CPT: Poems
│   ├── custom-taxonomies.php        # Taxonomies: Collections, Forms
│   ├── template-tags.php            # Custom template functions
│   ├── template-functions.php       # Additional theme functions
│   ├── customizer.php               # Customizer settings
│   ├── custom-header.php            # Custom header support (optional)
│   ├── blocks/                      # Gutenberg blocks
│   │   ├── verse-block/
│   │   │   ├── block.json
│   │   │   ├── edit.js
│   │   │   ├── save.js
│   │   │   ├── style.scss
│   │   │   └── editor.scss
│   │   ├── stanza-block/
│   │   ├── epigraph-block/
│   │   ├── dedication-block/
│   │   └── annotation-block/
│   ├── block-patterns/              # Custom block patterns
│   │   ├── poem-layouts.php
│   │   └── author-bios.php
│   └── admin/
│       ├── meta-boxes.php           # Custom meta boxes
│       └── admin-styles.css         # Admin area styling
│
├── assets/
│   ├── css/
│   │   ├── base/
│   │   │   ├── normalize.css
│   │   │   ├── typography.css
│   │   │   └── variables.css        # CSS custom properties
│   │   ├── layout/
│   │   │   ├── grid.css
│   │   │   ├── header.css
│   │   │   ├── footer.css
│   │   │   └── navigation.css
│   │   ├── components/
│   │   │   ├── buttons.css
│   │   │   ├── forms.css
│   │   │   ├── cards.css
│   │   │   └── audio-player.css
│   │   ├── poems/
│   │   │   ├── single-poem.css      # Single poem styles
│   │   │   ├── archive-poem.css     # Archive styles
│   │   │   └── reading-modes.css    # Light/dark/sepia modes
│   │   └── utilities/
│   │       ├── spacing.css
│   │       └── responsive.css
│   ├── js/
│   │   ├── navigation.js            # Mobile menu, accessibility
│   │   ├── reading-mode.js          # Theme switching (light/dark)
│   │   ├── poem-navigation.js       # Keyboard navigation between poems
│   │   ├── audio-player.js          # Custom audio player
│   │   ├── customizer-preview.js    # Live preview in customizer
│   │   └── admin-scripts.js         # Admin area scripts
│   ├── fonts/
│   │   └── (optional local fonts)
│   └── images/
│       ├── icons/                   # SVG icons
│       └── patterns/                # Optional subtle backgrounds
│
├── languages/
│   ├── versalia.pot                 # Translation template
│   └── README.md                    # Translation instructions
│
├── theme.json                       # WordPress 5.9+ configuration
├── package.json                     # Node dependencies
├── webpack.config.js                # Asset bundling
├── .eslintrc.js                    # JavaScript linting
├── .stylelintrc.js                 # CSS linting
└── README.md                        # Theme documentation
```

---

## Core Features Implementation

### 1. Custom Post Type: Poems

**Registration (inc/custom-post-types.php)**
```php
function versalia_register_poem_post_type() {
    $labels = array(
        'name'               => _x( 'Poems', 'post type general name', 'versalia' ),
        'singular_name'      => _x( 'Poem', 'post type singular name', 'versalia' ),
        'menu_name'          => _x( 'Poems', 'admin menu', 'versalia' ),
        'add_new'            => _x( 'Add New', 'poem', 'versalia' ),
        'add_new_item'       => __( 'Add New Poem', 'versalia' ),
        'edit_item'          => __( 'Edit Poem', 'versalia' ),
        'new_item'           => __( 'New Poem', 'versalia' ),
        'view_item'          => __( 'View Poem', 'versalia' ),
        'search_items'       => __( 'Search Poems', 'versalia' ),
        'not_found'          => __( 'No poems found', 'versalia' ),
        'not_found_in_trash' => __( 'No poems found in Trash', 'versalia' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'poem', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-edit',
        'show_in_rest'       => true, // Gutenberg support
        'supports'           => array( 'title', 'editor', 'author', 'excerpt', 'comments', 'custom-fields', 'revisions' ),
        'taxonomies'         => array( 'collection', 'poetry_form', 'post_tag' ),
    );

    register_post_type( 'poem', $args );
}
```

**Custom Meta Fields Required:**
- `poem_date_written` - Date the poem was written (separate from publish date)
- `poem_dedication` - Optional dedication text
- `poem_epigraph` - Optional epigraph/quote
- `poem_epigraph_attribution` - Attribution for epigraph
- `poem_audio_url` - URL to audio recording
- `poem_original_language` - For translations
- `poem_translator` - Translator name(s)
- `poem_form_notes` - Notes about poetic form/structure
- `poem_reading_time` - Estimated reading time in minutes

### 2. Custom Taxonomies

**Collections (inc/custom-taxonomies.php)**
```php
function versalia_register_collection_taxonomy() {
    $labels = array(
        'name'              => _x( 'Collections', 'taxonomy general name', 'versalia' ),
        'singular_name'     => _x( 'Collection', 'taxonomy singular name', 'versalia' ),
        'search_items'      => __( 'Search Collections', 'versalia' ),
        'all_items'         => __( 'All Collections', 'versalia' ),
        'parent_item'       => __( 'Parent Collection', 'versalia' ),
        'parent_item_colon' => __( 'Parent Collection:', 'versalia' ),
        'edit_item'         => __( 'Edit Collection', 'versalia' ),
        'update_item'       => __( 'Update Collection', 'versalia' ),
        'add_new_item'      => __( 'Add New Collection', 'versalia' ),
        'new_item_name'     => __( 'New Collection Name', 'versalia' ),
        'menu_name'         => __( 'Collections', 'versalia' ),
    );

    $args = array(
        'hierarchical'      => true, // Like categories
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'collection' ),
    );

    register_taxonomy( 'collection', array( 'poem' ), $args );
}
```

**Poetry Forms Taxonomy**
- Pre-populate with: Sonnet, Haiku, Free Verse, Villanelle, Sestina, Limerick, Ode, Elegy, Ballad, Acrostic, Blank Verse, etc.
- Allow users to add custom forms
- Display form guidelines in taxonomy description

### 3. Custom Gutenberg Blocks

**Verse Block (inc/blocks/verse-block/)**

**Purpose**: Preserves line breaks and spacing exactly as poet intends

**Features**:
- Pre-formatted text that maintains all whitespace
- Line number toggle (optional)
- Indentation controls for individual lines
- Alignment options (left, center, right)
- Font size adjustments
- Custom line-height control

**Block.json**:
```json
{
  "apiVersion": 2,
  "name": "versalia/verse",
  "title": "Verse",
  "category": "text",
  "icon": "editor-paragraph",
  "description": "Display poetry with preserved formatting and line breaks.",
  "keywords": ["poem", "poetry", "verse", "lines"],
  "textdomain": "versalia",
  "attributes": {
    "content": {
      "type": "string",
      "source": "html",
      "selector": ".verse-content"
    },
    "alignment": {
      "type": "string",
      "default": "left"
    },
    "showLineNumbers": {
      "type": "boolean",
      "default": false
    },
    "fontSize": {
      "type": "string",
      "default": "medium"
    },
    "lineHeight": {
      "type": "number",
      "default": 2.0
    }
  },
  "supports": {
    "html": false,
    "align": ["wide", "full"]
  },
  "editorScript": "file:./edit.js",
  "editorStyle": "file:./editor.css",
  "style": "file:./style.css"
}
```

**Stanza Block**
- Groups verses into stanzas
- Automatic spacing between stanzas
- Optional stanza numbers
- Nested verse blocks

**Epigraph Block**
- Quote display before poem
- Attribution field
- Italic styling by default
- Right-aligned option

**Dedication Block**
- Special formatting for dedications
- Italic, centered by default
- "For..." prefix option

**Annotation Block**
- Footnote-style annotations
- Reference markers in text
- Expandable/collapsible notes
- Academic citation support

### 4. Single Poem Template (single-poem.php)

**Layout Requirements**:
- Maximum content width: 720px for optimal reading
- Generous margins: 60px mobile, 120px desktop
- Centered content by default
- Clean, minimal header
- Previous/Next poem navigation (keyboard accessible)
- Author bio box (optional, via customizer)
- Social sharing (minimal, customizer controlled)
- Comment section (optional)

**Reading Modes**:
- Light mode (default): #FAFAF8 background, #2C2C2C text
- Dark mode: #1A1A1A background, #E5E5E5 text
- Sepia mode: #F4ECD8 background, #5C4B37 text
- Save preference in localStorage
- Smooth transition between modes (300ms)

**Typography**:
- Title: 2.5rem - 4rem, weight 400-500, letter-spacing tight
- Body: 1.125rem - 1.375rem, line-height 1.8-2.2
- Meta info: 0.875rem, uppercase, letter-spacing wide
- Monospace option for experimental poetry

**Metadata Display**:
- Date written (if different from published)
- Poetry form badge
- Reading time estimate
- Collection breadcrumb
- Tags (minimal)

### 5. Archive Templates

**Archive-Poem.php Views**:

**List View (Default)**:
- Poem title (large, elegant)
- First line or excerpt
- Author name
- Date
- Optional first letter decoration
- Clean separators between items
- Fade-in animations on scroll

**Grid View**:
- Card-based layout
- 2-3 columns on desktop
- Title + excerpt
- Hover effects (subtle)
- Masonry layout option

**Minimal View**:
- Title only
- Grouped by collection or date
- Timeline style
- Alphabet索引 for large archives

**Filtering Options**:
- By collection
- By poetry form
- By author
- By date
- Search integration

### 6. Typography System

**Font Pairing Presets** (via Customizer):

**Preset 1: Classic Elegance**
- Headings: Crimson Text (400, 600)
- Body: Crimson Text (400, 400 italic)
- UI: Inter (400, 500)

**Preset 2: Modern Literary**
- Headings: EB Garamond (400, 500)
- Body: EB Garamond (400, 400 italic)
- UI: Work Sans (400, 500)

**Preset 3: Contemporary**
- Headings: Spectral (300, 400)
- Body: Spectral (300, 300 italic)
- UI: Karla (400, 500)

**Preset 4: Traditional**
- Headings: Libre Baskerville (400, 700)
- Body: Libre Baskerville (400, 400 italic)
- UI: Source Sans Pro (400, 600)

**Typography Scale** (using CSS custom properties):
```css
:root {
  /* Base size */
  --font-size-base: 1.125rem; /* 18px */
  
  /* Scale ratio: 1.250 (Major Third) */
  --font-size-xs: 0.72rem;    /* 11.52px */
  --font-size-sm: 0.9rem;     /* 14.4px */
  --font-size-md: 1.125rem;   /* 18px - base */
  --font-size-lg: 1.406rem;   /* 22.5px */
  --font-size-xl: 1.758rem;   /* 28.13px */
  --font-size-2xl: 2.197rem;  /* 35.16px */
  --font-size-3xl: 2.747rem;  /* 43.95px */
  --font-size-4xl: 3.433rem;  /* 54.93px */
  
  /* Line heights */
  --line-height-tight: 1.2;
  --line-height-normal: 1.5;
  --line-height-relaxed: 1.8;
  --line-height-loose: 2.0;
  --line-height-poetry: 2.2;
  
  /* Letter spacing */
  --letter-spacing-tight: -0.02em;
  --letter-spacing-normal: 0;
  --letter-spacing-wide: 0.05em;
  --letter-spacing-wider: 0.1em;
}
```

### 7. Audio Player Integration

**Features Required**:
- Custom HTML5 audio player
- Play/pause, seek, volume controls
- Playback speed control (0.75x, 1x, 1.25x, 1.5x)
- Download button
- Minimalist design matching theme
- Keyboard accessible
- Progress bar with timestamps
- Auto-scroll to follow reading (optional)

**Implementation**:
- Meta box in poem editor for audio URL
- Support for self-hosted and external URLs (SoundCloud, etc.)
- Waveform visualization (optional, using wavesurfer.js)
- Multiple recordings per poem (different readers/languages)

### 8. Navigation & User Experience

**Keyboard Shortcuts**:
- `←` Previous poem
- `→` Next poem
- `H` Home/Archive
- `R` Random poem
- `L` Toggle reading mode (light/dark/sepia)
- `?` Show keyboard shortcuts help

**Mobile Navigation**:
- Swipe left/right between poems
- Hamburger menu for mobile
- Bottom navigation bar option
- Pull-to-refresh for random poem

**Accessibility**:
- Skip to content link
- ARIA labels on all interactive elements
- Focus indicators (subtle but visible)
- Screen reader optimized
- Respects prefers-reduced-motion
- Respects prefers-color-scheme for default mode

### 9. Customizer Options (inc/customizer.php)

**General Settings Panel**:
- Site layout (boxed/full-width)
- Container max-width
- Reading mode default
- Enable/disable features

**Typography Panel**:
- Font pairing presets
- Custom font uploads
- Font size adjustments
- Line height controls
- Letter spacing

**Colors Panel**:
- Primary accent color
- Background colors (light/dark/sepia modes)
- Text colors
- Link colors
- Border colors

**Poem Display Panel**:
- Show/hide poem metadata
- Date format
- Show/hide author box
- Enable/disable comments
- Show/hide social sharing
- Previous/next navigation style

**Layout Options Panel**:
- Archive view style (list/grid/minimal)
- Sidebar position (left/right/none)
- Footer layout
- Header style

**Advanced Panel**:
- Custom CSS
- Custom JavaScript
- Analytics code insertion
- Schema.org markup options

### 10. Performance Optimization

**Critical CSS**:
- Inline critical CSS for above-the-fold content
- Defer non-critical CSS
- Font loading optimization (font-display: swap)

**Image Optimization**:
- Lazy loading for featured images
- Responsive images with srcset
- WebP support with fallbacks

**JavaScript**:
- Defer non-critical scripts
- Minimize jQuery usage
- Tree-shaking unused code
- Code splitting

**Caching**:
- Leverage browser caching headers
- Support for WP caching plugins
- Transient API for expensive queries

**Database**:
- Efficient queries
- Pagination for archives
- Limit post meta queries

### 11. SEO & Schema.org Markup

**Structured Data**:
```json
{
  "@context": "https://schema.org",
  "@type": "CreativeWork",
  "@id": "poem-url",
  "name": "Poem Title",
  "author": {
    "@type": "Person",
    "name": "Poet Name"
  },
  "datePublished": "2024-01-01",
  "dateCreated": "2023-12-15",
  "inLanguage": "en",
  "text": "Poem content...",
  "genre": "Poetry"
}
```

**Meta Tags**:
- Open Graph for social sharing
- Twitter Cards
- Canonical URLs
- Proper meta descriptions

### 12. Admin Experience

**Meta Boxes**:
- Poem Details (date written, dedication, epigraph)
- Audio Recording
- Translation Information
- Reading Settings
- Display Options

**Custom Admin Columns**:
- Poetry form
- Collection
- Date written
- Audio status
- Reading time

**Quick Edit Support**:
- Common fields available in quick edit
- Bulk editing for collections/forms

**Editor Enhancements**:
- Custom block patterns for common poem layouts
- Style variations for blocks
- Template suggestions

---

## Testing Requirements

### Browser Support
- **Desktop**: Latest 2 versions of Chrome, Firefox, Safari, Edge
- **Mobile**: iOS Safari 13+, Chrome Android 90+
- **Graceful degradation**: IE11 basic support (no CSS Grid fallback)

### Responsive Breakpoints
```css
/* Mobile first approach */
$breakpoint-sm: 576px;   /* Small tablets */
$breakpoint-md: 768px;   /* Tablets */
$breakpoint-lg: 1024px;  /* Desktop */
$breakpoint-xl: 1280px;  /* Large desktop */
$breakpoint-2xl: 1536px; /* Extra large */
```

### Testing Checklist
- [ ] WordPress theme check plugin passes
- [ ] PHP CodeSniffer (WordPress standards)
- [ ] Accessibility audit (WAVE, aXe)
- [ ] Cross-browser testing
- [ ] Mobile device testing
- [ ] RTL language testing
- [ ] Performance testing (GTmetrix, Lighthouse)
- [ ] Security scan (Theme Sniffer)
- [ ] Translation readiness
- [ ] Print stylesheet testing

---

## Development Workflow

### Phase 1: Foundation (Week 1-2)
**Deliverables**:
- [ ] File structure setup
- [ ] Theme registration and basic setup
- [ ] Custom post type (Poems) registration
- [ ] Custom taxonomies registration
- [ ] Basic template hierarchy
- [ ] Typography system implementation
- [ ] CSS architecture setup
- [ ] Build tools configuration

### Phase 2: Templates & Layouts (Week 3-4)
**Deliverables**:
- [ ] single-poem.php with all features
- [ ] archive-poem.php with view options
- [ ] Author template
- [ ] Taxonomy templates
- [ ] Page templates (chapbook, full-width)
- [ ] Header/footer templates
- [ ] Navigation system
- [ ] Responsive design implementation

### Phase 3: Custom Blocks (Week 5-6)
**Deliverables**:
- [ ] Verse block
- [ ] Stanza block
- [ ] Epigraph block
- [ ] Dedication block
- [ ] Annotation block
- [ ] Block patterns
- [ ] Block editor styles

### Phase 4: Features & Functionality (Week 7-8)
**Deliverables**:
- [ ] Reading modes (light/dark/sepia)
- [ ] Audio player integration
- [ ] Meta boxes and custom fields
- [ ] Keyboard navigation
- [ ] Search functionality
- [ ] Comment system styling
- [ ] Social sharing integration

### Phase 5: Customizer & Options (Week 9-10)
**Deliverables**:
- [ ] Customizer panels and controls
- [ ] Live preview functionality
- [ ] Font pairing system
- [ ] Color scheme options
- [ ] Layout options
- [ ] Advanced settings

### Phase 6: Polish & Optimization (Week 11-12)
**Deliverables**:
- [ ] Performance optimization
- [ ] Accessibility improvements
- [ ] Cross-browser fixes
- [ ] Mobile refinements
- [ ] Animation and transitions
- [ ] Loading states
- [ ] Error handling

### Phase 7: Testing & Documentation (Week 13-14)
**Deliverables**:
- [ ] Complete testing suite
- [ ] Bug fixes
- [ ] User documentation
- [ ] Developer documentation
- [ ] Translation files
- [ ] Demo content
- [ ] Screenshots and marketing materials

---

## Code Standards & Best Practices

### PHP Standards
```php
// Use strict types
declare(strict_types=1);

// Proper escaping
echo esc_html( $text );
echo esc_url( $url );
echo esc_attr( $attribute );

// Sanitization
$clean_data = sanitize_text_field( $_POST['field'] );

// Nonce verification
if ( ! wp_verify_nonce( $_POST['nonce'], 'action_name' ) ) {
    wp_die( 'Security check failed' );
}

// Prepared statements for DB queries
$wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE ID = %d", $post_id );

// Translation functions
__( 'Text', 'versalia' );
_e( 'Text', 'versalia' );
_x( 'Text', 'context', 'versalia' );
esc_html__( 'Text', 'versalia' );

// Action/Filter hooks with priority
add_action( 'hook_name', 'function_name', 10, 1 );
add_filter( 'filter_name', 'function_name', 10, 1 );
```

### JavaScript Standards
```javascript
// ES6+ modules
import { Component } from './components';

// Arrow functions
const greet = (name) => `Hello, ${name}`;

// Destructuring
const { title, content } = post;

// Template literals
const message = `Welcome to ${siteName}`;

// Async/await
async function fetchPoem(id) {
    const response = await fetch(`/api/poems/${id}`);
    return response.json();
}

// Error handling
try {
    // code
} catch (error) {
    console.error('Error:', error);
}
```

### CSS Standards
```css
/* BEM naming convention */
.block__element--modifier { }

/* CSS custom properties for theming */
:root {
    --color-primary: #2C2C2C;
    --spacing-unit: 8px;
}

/* Mobile-first media queries */
.element {
    /* Mobile styles */
}

@media (min-width: 768px) {
    .element {
        /* Tablet and up */
    }
}

/* Logical properties for RTL support */
margin-inline-start: 1rem;
padding-block-end: 2rem;
```

### Git Workflow
```bash
# Branch naming
feature/verse-block
fix/navigation-bug
refactor/typography-system
docs/installation-guide

# Commit messages
feat: Add verse block with line number support
fix: Resolve mobile navigation overlay issue
refactor: Optimize database queries for archives
docs: Update customizer documentation
style: Format CSS according to standards
test: Add unit tests for meta boxes
```

---

## Documentation Requirements

### User Documentation
1. **Installation Guide**
   - WordPress installation
   - Theme activation
   - Initial setup wizard
   - Recommended plugins

2. **Getting Started**
   - Creating your first poem
   - Using custom blocks
   - Organizing collections
   - Setting up audio

3. **Customization Guide**
   - Using the Customizer
   - Typography options
   - Color schemes
   - Layout configuration

4. **Features Guide**
   - Reading modes
   - Navigation
   - Author profiles
   - Chapbooks

5. **Troubleshooting**
   - Common issues
   - FAQ
   - Support resources

### Developer Documentation
1. **Theme Structure**
   - File organization
   - Template hierarchy
   - Hooks and filters

2. **Customization**
   - Child theme creation
   - Custom blocks
   - Template overrides
   - Adding custom fields

3. **API Reference**
   - Template tags
   - Functions
   - Filters
   - Actions

4. **Contributing Guide**
   - Code standards
   - Pull request process
   - Testing requirements

---

## Monetization Strategy

### Free Version (WordPress.org)
**Features**:
- Custom post type and taxonomies
- Basic Gutenberg blocks (Verse, Stanza)
- 2 archive layouts (List, Grid)
- 3 font pairings
- Light/Dark reading modes
- Basic customizer options
- Single audio upload per poem
- Author bio box
- Standard navigation

**Limitations**:
- No Sepia mode
- No advanced blocks (Annotation, Translation)
- No custom fonts upload
- Basic color options only
- No chapbook templates
- No submission forms
- Standard support only

### Pro Version (Premium)
**Additional Features**:
- All reading modes (Light/Dark/Sepia + custom)
- Advanced Gutenberg blocks (Annotation, Translation, Dedication, Epigraph)
- Unlimited font pairings + custom font upload
- Advanced color schemes with gradients
- All archive layouts (List, Grid, Minimal, Timeline)
- Chapbook page templates
- Multiple audio recordings per poem
- Waveform audio visualizer
- Translation side-by-side display
- Submission form builder
- Contest management system
- Advanced typography controls
- Custom CSS and JS panels
- Schema.org enhancements
- Priority email support
- Lifetime updates

**Pricing Tiers**:
- **Single Site**: $59/year or $149 lifetime
- **5 Sites**: $99/year or $249 lifetime
- **Unlimited**: $149/year or $399 lifetime

### Add-ons (Optional)
1. **Poetry Workshop** ($29)
   - Critique submission system
   - Private feedback tools
   - Workshop scheduling

2. **Literary Magazine** ($49)
   - Submission management
   - Editorial workflow
   - Issue publication tools

3. **Multi-language Pack** ($19)
   - Advanced translation features
   - Bilingual displays
   - Language switcher

---

## Success Metrics

### Performance Targets
- **Page Load**: < 2 seconds (3G connection)
- **Lighthouse Score**: 90+ across all metrics
- **First Contentful Paint**: < 1.5s
- **Time to Interactive**: < 3s
- **CSS Size**: < 100KB minified
- **JS Size**: < 150KB minified

### User Experience Goals
- **Mobile Reading**: Seamless, no horizontal scroll
- **Accessibility**: WCAG 2.1 AA compliant
- **Browser Support**: 98%+ of users
- **Theme Switch Time**: < 1 second

### Business Metrics (Post-Launch)
- **Free Downloads**: 1000+ in first 3 months
- **Pro Conversion**: 5-10% of free users
- **Support Tickets**: < 5% of users
- **Positive Reviews**: 4.5+ stars average
- **Return Rate**: < 2% refund requests

---

## Launch Checklist

### Pre-Launch (WordPress.org Submission)
- [ ] Theme passes Theme Check plugin
- [ ] GPL-compatible licensing
- [ ] No external dependencies (except allowed APIs)
- [ ] Proper theme header in style.css
- [ ] Screenshot.png present and valid
- [ ] readme.txt complete with changelog
- [ ] All text strings translatable
- [ ] No PHP/JS errors in debug mode
- [ ] Passes accessibility audit
- [ ] Demo content included
- [ ] Documentation complete

### Marketing Materials
- [ ] Theme demo website
- [ ] Video walkthrough
- [ ] Feature list page
- [ ] Comparison chart (Free vs Pro)
- [ ] Screenshots for all features
- [ ] Social media graphics
- [ ] Email announcement template
- [ ] Blog post announcement
- [ ] Press kit

### Support Setup
- [ ] Documentation site live
- [ ] Support ticket system
- [ ] FAQ page
- [ ] Community forum
- [ ] Video tutorials
- [ ] Changelog page
- [ ] Knowledge base

---

## Future Enhancements (Roadmap)

### Version 1.1
- AI-powered poetry suggestions
- Reading analytics for poets
- Social features (following poets)
- Poem rating/favorites system

### Version 1.2
- Collaborative writing tools
- Version history for poems
- Advanced search (by meter, rhyme scheme)
- Poem generator/writing prompts

### Version 1.3
- Mobile app (React Native)
- Poetry podcast integration
- Live reading events
- Virtual poetry slams

### Version 2.0
- Headless CMS support (REST API)
- GraphQL API
- React-based theme variant
- Advanced ML features (style analysis)

---

## Support & Maintenance Plan

### Update Schedule
- **Security patches**: Immediate
- **Bug fixes**: Weekly releases
- **Minor features**: Monthly releases
- **Major versions**: Quarterly

### Support Channels
1. **Free Version**:
   - WordPress.org forum
   - Documentation site
   - Video tutorials
   - Response time: 5-7 days

2. **Pro Version**:
   - Email support
   - Priority ticket system
   - Live chat (business hours)
   - Response time: 24-48 hours

### Maintenance Tasks
- Monthly WordPress core compatibility check
- Quarterly performance audit
- Bi-annual accessibility review
- Annual security audit
- Continuous dependency updates

---

## Conclusion

This specification provides a complete roadmap for developing Versalia, a premium WordPress theme specifically designed for poetry. The theme balances minimal aesthetics with powerful features, offering poets and publishers a platform that respects the art form while leveraging modern web technologies.

**Key Differentiators**:
1. Poetry-specific formatting tools unavailable elsewhere
2. Academic-grade annotation and translation support
3. Superior mobile reading experience
4. Audio integration for performance poetry
5. Accessibility-first design philosophy

**Development Timeline**: 14 weeks for MVP
**Target Launch**: Q2 2024
**Primary Market**: Individual poets, literary magazines, academic poetry journals
**Secondary Market**: Translation publishers, poetry collectives, writing workshops

The theme will establish itself as the definitive WordPress solution for poetry by addressing the unique needs of this creative community while maintaining the flexibility to serve diverse use cases from personal blogs to institutional publications.