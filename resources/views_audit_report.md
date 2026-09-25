Views UI Audit Report

Summary:
- Scanned: `resources/views/**/*.blade.php` for inline styles, inline scripts, raw tables, and form elements without framework classes.
- Findings: multiple views contain inline `style="..."`, embedded `<script>` blocks, and inline event handlers. Top offenders: `welcome.blade.php`, `dashboard.blade.php`, `print_manifest.blade.php`, `login.blade.php`.

Files & Issues (high-level):

- `welcome.blade.php`:
  - Many inline `style` attributes (layout, colors, spacing, modal styling).
  - Embedded `<script>` tags and third-party CDN scripts at bottom.
  - Inline image styles and button inline styles.
  - Recommendation: extract visual styles to a shared CSS file; move scripts to a single footer include.

- `dashboard.blade.php`:
  - Numerous inline styles for cards, badges, buttons, hero areas, and alerts.
  - Tables with inline `style` on rows/cells and images with inline sizes.
  - Mixed use of utility classes and custom inline CSS — leads to inconsistency.
  - Recommendation: create Blade partials for cards, table rows, and alerts; replace inline styles with CSS variables and utility classes.

- `print_manifest.blade.php`:
  - Print-specific inline styles (buttons, headings, table cell alignment).
  - Recommendation: keep minimal print stylesheet (`print.css`) and remove inline print styles.

- `login.blade.php`:
  - Inline alert styles and a custom `btn-green` class used on submit without consistent Bootstrap usage.
  - Recommendation: standardize button classes and extract alert styling.

- Other files observed with inline styles or event handlers:
  - Many partials and modals across views contain inline `style` or inline JS (examples: modal-close buttons, hero images, gallery markup).

Automated counts (sample):
- Total grep matches found for patterns (style/script/input/select/button/table): 200+ (truncated).
- Top patterns: `style="` and inline `<script>` tags are widespread.

Risk & Impact:
- Maintainability: inline styles make theme changes hard and introduce duplication.
- Consistency: inconsistent controls (buttons/inputs) reduce usability and visual coherence.
- Accessibility: inline styles may omit focus states and proper ARIA attributes.

Recommended next steps (small, incremental):
1. Create a shared backend stylesheet `public/css/admin.css` (or Vite asset) with CSS variables for primary colors, badge states, spacing, and utility classes.
2. Replace inline `style` in the top 4 files (`welcome`, `dashboard`, `print_manifest`, `login`) by moving rules into the shared stylesheet.
3. Create Blade partials for common UI pieces: `components/alert.blade.php`, `components/button.blade.php`, `components/hero.blade.php`, and reuse them.
4. Consolidate scripts into a single `@include('partials.scripts')` loaded at the end of layout.
5. Run manual QA on responsive breakpoints after changes.

Would you like me to: (A) automatically extract and replace inline styles in the top 4 files, or (B) create the shared CSS and Blade partials but leave manual replacements to you? Reply with A or B.