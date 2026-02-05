# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-02-05

### Added

#### Phase 1: Core Form Enhancements

- Automatic validation error styling (Bootstrap `is-invalid`, Tailwind `border-red-500`)
- PHP 8.1+ Enum support for select lists
- ErrorBag integration with `aria-invalid` attributes
- Automatic HTML5 validation attribute mapping

#### Phase 2: Utility Helpers

- `breadcrumbs()` helper with theme support
- `gravatar()` helper for Gravatar URLs and images
- `activeClass()` helper for navigation link highlighting

#### Phase 3: UI Components

- `alert()` component (theme-aware, dismissible)
- `card()` component with header, body, and footer
- `modal()` component with Bootstrap/Tailwind styling

#### Phase 4: Framework Integration

- Livewire helper methods: `wire()`, `wireLazy()`, `wireDefer()`, `wireLive()`
- Livewire event helpers: `wireClick()`, `wireSubmit()`, `wireSubmitPrevent()`
- Blade component views for all form elements
- Automatic `old()` value handling in Blade components

#### Phase 5: Smart Inputs

- `rules()` method for HTML5 validation rule parsing
- `toggle()` component for iOS-style switches
- `colorPicker()` for native HTML5 color input
- `rating()` component for star ratings

#### Phase 6: Advanced Selects

- `searchableSelect()` with HTML5 datalist
- `multiSelect()` for multiple selections
- `ajaxSelect()` for dynamic option loading
- `autocomplete()` with static and AJAX support

#### Phase 7: Date/Time & File Uploads

- `datePicker()` for native HTML5 date input
- `timePicker()` for native HTML5 time input
- `dateRangePicker()` for start/end date selection
- `fileUpload()` with image preview functionality
- `multipleFiles()` for uploading multiple files

#### Phase 8: Rich Content

- `richText()` editor with contenteditable and toolbar
- `inlineEdit()` for click-to-edit functionality
- `wizard()` for multi-step form navigation

#### Phase 9: Additional UI Components

- `progressBar()` with striped and animated variants
- `badge()` and `pill()` for status indicators
- `tabs()` component for tabbed content
- `accordion()` for collapsible sections
- `tooltip()` for hover information
- `popover()` for click-to-show content

### Changed

- Updated to strict PHP 8.2+ typing across all methods
- Improved accessibility with automatic ARIA attributes
- Enhanced theme support for Bootstrap and Tailwind CSS

### Fixed

- Form field population with model binding
- Error state handling in Blade components
- Theme class application consistency

## [Unreleased]

### Planned

- Additional JavaScript framework integrations
- More UI component variants
- Enhanced accessibility features
- Performance optimizations

---

[1.0.0]: https://github.com/ermradulsharma/laravel-html/releases/tag/v1.0.0
