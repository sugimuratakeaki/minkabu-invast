# Account Opening Section - Design Specifications
# 口座開設セクション - デザイン仕様書

## Overview
This document provides comprehensive design specifications for the account opening section of the minkabu-invast WordPress site.

## Design System

### Color Palette
```css
/* Primary Colors */
--primary-blue: #1e50a2;      /* Main blue color */
--secondary-blue: #2563eb;    /* Lighter blue for gradients */
--highlight-yellow: #ffd700;  /* Yellow for headline highlight */

/* Neutral Colors */
--text-primary: #333;         /* Main text color */
--text-secondary: #6b7280;    /* Secondary text color */
--border-color: #e5e7eb;      /* Border color */
--background: #f8f9fa;        /* Section background */
--card-bg: #fff;             /* Card background */

/* Shadows */
--shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
--shadow-md: 0 4px 12px rgba(0,0,0,0.1);
--shadow-lg: 0 4px 15px rgba(30,80,162,0.3);
```

### Typography
```css
/* Font Stack */
font-family: "Hiragino Kaku Gothic ProN", "ヒラギノ角ゴ ProN", 
             "メイリオ", Meiryo, "ＭＳ Ｐゴシック", sans-serif;

/* Font Sizes */
--headline-size-pc: 32px;
--headline-size-mobile: 24px;
--section-title: 24px;
--card-title: 14px;
--body-text: 14px;
--number-badge: 18px;
```

### Spacing System
```css
/* Consistent spacing units */
--spacing-xs: 5px;
--spacing-sm: 10px;
--spacing-md: 15px;
--spacing-lg: 20px;
--spacing-xl: 30px;
--spacing-2xl: 40px;
--spacing-3xl: 60px;
```

## Component Architecture

### 1. Main Headline Component
- **Purpose**: Grab attention with highlighted text
- **Design Pattern**: Linear gradient background for highlight effect
- **Implementation**:
  ```css
  .highlight {
    background: linear-gradient(transparent 60%, #ffd700 60%);
  }
  ```

### 2. 4-Step Cards Component
- **Layout**: Horizontal flexbox on desktop, 2x2 grid on mobile
- **Visual Features**:
  - Numbered badges with blue background
  - SVG icons for visual clarity
  - Triangle arrow connectors between steps
  - Hover effects for interactivity

### 3. Arrow Connectors
- **Desktop**: Blue triangle arrows between cards
- **Mobile**: Directional arrows adapted for grid layout
- **CSS Triangle Technique**:
  ```css
  border-left: 20px solid #1e50a2;
  border-top: 15px solid transparent;
  border-bottom: 15px solid transparent;
  ```

### 4. Detailed Steps List
- **Layout**: Vertical list with numbered items
- **Design Elements**:
  - Gradient background for step numbers
  - Card-based layout with subtle shadows
  - Hover animations for engagement

## Responsive Design Strategy

### Breakpoints
```css
/* Mobile First Approach */
@media screen and (max-width: 768px)    /* Mobile */
@media screen and (min-width: 769px) and (max-width: 1024px)  /* Tablet */
@media screen and (min-width: 1025px)   /* Desktop */
```

### Mobile Adaptations
1. **4-Step Cards**: Transform from horizontal to 2x2 grid
2. **Arrow Connectors**: Reposition for grid flow
3. **Font Sizes**: Scale down appropriately
4. **Spacing**: Reduce padding and margins

## Interaction Design

### Hover States
```css
/* Card hover effect */
.account-step-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Button hover effect */
.account-cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30,80,162,0.4);
}
```

### Animation Classes
```css
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
```

## Accessibility Considerations

### WCAG Guidelines
- **Color Contrast**: Minimum 4.5:1 ratio for text
- **Interactive Elements**: Minimum 44x44px touch targets
- **Focus States**: Visible keyboard focus indicators
- **Semantic HTML**: Proper heading hierarchy

### Screen Reader Support
- Meaningful alt text for icons
- Proper ARIA labels where needed
- Logical reading order

## Implementation Files

### CSS Files
- `/assets/css/account-opening.css` - Main styles

### Template Files
- `/template-parts/account-opening.php` - Basic template with emoji icons
- `/template-parts/account-opening-enhanced.php` - Enhanced with SVG icons
- `/page-account-demo.php` - Demo page template

## Usage Instructions

### Basic Implementation
```php
<?php get_template_part('template-parts/account-opening-enhanced'); ?>
```

### WordPress Page Template
1. Create a new page in WordPress
2. Select "Account Opening Demo" template
3. Publish the page

### Customization Options

#### Change CTA Link
Edit in template file:
```php
<a href="/your-custom-url" class="account-cta-button">
```

#### Modify Colors
Override in custom CSS:
```css
.account-opening-section {
    --primary-blue: #your-color;
}
```

#### Add/Remove Steps
Edit the template file to add or remove step cards and detailed items.

## Performance Optimization

### CSS Optimization
- Minimal specificity for easy overrides
- Efficient selectors
- Grouped properties

### Animation Performance
- Use `transform` and `opacity` for animations
- Avoid animating layout properties
- Hardware acceleration with `will-change`

## Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Testing Checklist
- [ ] Desktop view (1920x1080)
- [ ] Tablet view (768x1024)
- [ ] Mobile view (375x667)
- [ ] Cross-browser testing
- [ ] Keyboard navigation
- [ ] Screen reader testing
- [ ] Performance metrics

## Future Enhancements
1. Add progress bar animation
2. Implement step completion tracking
3. Add video tutorials for each step
4. Integrate with form validation
5. Add multi-language support