# Implementation Plan: Book Catalog

## Overview

Incremental implementation of the Book Catalog on PHP 8+, Yii2 Basic, MySQL/MariaDB, file-based RBAC, and SmsPilot. Each task is scoped to a single focused unit of work (one professional Git commit). Tasks follow the logical order: cleanup → config → migrations → models → RBAC → auth → CRUD controllers → SMS → UI → tests.

## Tasks

- [ ] 1. Project cleanup — remove Yii2 demo files
  - Delete `controllers/SiteController.php` demo actions (`actionAbout`, `actionContact`) and keep only `actionIndex`, `actionLogin`, `actionLogout`, `actionError`
  - Delete `views/site/about.php`, `views/site/contact.php`
  - Delete `models/ContactForm.php`
  - Delete `commands/HelloController.php`
  - Remove demo test files: `tests/acceptance/AboutCest.php`, `tests/acceptance/ContactCest.php`, `tests/functional/ContactFormCest.php`, `tests/unit/models/ContactFormTest.php`, `tests/unit/widgets/AlertTest.php`
  - _Requirements: 4.5 (clean navigation baseline)_

- [ ] 2. Configuration — params, DB, web.php, gitignore
  - [ ] 2.1 Update `config/params.php` — add `smsPilotApiKey` (default `'DEMO'`) and `smsPilotSender` (default `'INFORM'`)
    - _Requirements: 6.4_
  - [ ] 2.2 Update `config/db.php` — set DSN, username, password for local MySQL; add `config/db.php` to `.gitignore`; provide `config/db.php.example`
    - _Requirements: 8.1, 8.2_
  - [ ] 2.3 Update `config/web.php` — register `smsPilot` component (`app\components\SmsPilotService`) and `authManager` (`yii\rbac\PhpManager` pointing to `config/rbac/`)
    - _Requirements: 4.1, 6.4_
  - [ ] 2.4 Add `web/uploads/covers/` to `.gitignore`; create `web/uploads/covers/.gitkeep`
    - _Requirements: 1.5_

- [ ] 3. Migrations
  - [ ] 3.1 Create migration for `user` table — columns: `id`, `username` (unique), `password_hash`, `auth_key`, `status`, `created_at`, `updated_at`
    - _Requirements: 8.1, 8.3_
  - [ ] 3.2 Create migration for `author` table — columns: `id`, `full_name`, `created_at`, `updated_at`
    - _Requirements: 2.1, 8.1, 8.3_
  - [ ] 3.3 Create migration for `book` table — columns: `id`, `title`, `year` (with `idx_book_year` index), `description`, `isbn`, `cover_path`, `created_at`, `updated_at`
    - _Requirements: 1.1, 8.1, 8.3_
  - [ ] 3.4 Create migration for `book_author` join table — composite PK `(book_id, author_id)`, FK to `book` and `author` with `ON DELETE CASCADE`
    - _Requirements: 1.9, 8.4_
  - [ ] 3.5 Create migration for `subscription` table — columns: `id`, `author_id` (FK to `author` CASCADE), `phone`, `created_at`; unique constraint on `(author_id, phone)`
    - _Requirements: 5.2, 8.5_

- [ ] 4. Models
  - [ ] 4.1 Implement `models/User.php` as a full Yii2 `IdentityInterface` — `findIdentity`, `findIdentityByAccessToken`, `findByUsername`, `validatePassword`, `generatePasswordHash`, `generateAuthKey`
    - _Requirements: 4.3, 4.4_
  - [ ] 4.2 Implement `components/IsbnValidator.php` — extends `yii\validators\Validator`; static `normalize(string): string` (strip hyphens/spaces); static `isValid(string): bool` (ISBN-10 and ISBN-13 check-digit algorithms); `validateValue` returns error message or null
    - _Requirements: 1.4, 10.1, 10.2, 10.3, 10.5_
  - [ ] 4.3 Implement `models/Author.php` — `rules()` with `full_name` required max 255; `getBooks()` via `book_author`; `getSubscriptions()` hasMany
    - _Requirements: 2.1, 2.5, 2.6_
  - [ ] 4.4 Implement `models/Book.php` — `rules()` with title/year required, `IsbnValidator` on isbn, `FileValidator` on `imageFile`; `beforeSave()` normalizes ISBN and handles `UploadedFile` → `web/uploads/covers/`; `afterDelete()` unlinks cover file; `getAuthors()` and `getBookAuthors()` relations
    - _Requirements: 1.1, 1.4, 1.5, 1.6, 1.7, 1.9, 10.1_
  - [ ] 4.5 Implement `models/BookAuthor.php` — minimal ActiveRecord for the join table with `book_id` and `author_id`
    - _Requirements: 1.9, 8.4_
  - [ ] 4.6 Implement `models/Subscription.php` — `rules()` with `author_id` required integer and `phone` matching `/^\+?\d{10,15}$/`; static `findOrCreate(int $authorId, string $phone)` catches unique constraint violation and returns existing record
    - _Requirements: 5.2, 5.3, 5.4, 5.5, 8.5_
  - [ ] 4.7 Implement `models/BookSearch.php` and `models/AuthorSearch.php` — `SearchModel` classes extending respective AR models with `search()` returning `ActiveDataProvider`
    - _Requirements: 3.1, 3.4_

- [ ] 5. RBAC setup
  - [ ] 5.1 Create `config/rbac/` directory with `items.php` — define permissions `manageBooks` and `manageAuthors`; define roles `guest` (no permissions) and `user` (both permissions)
    - _Requirements: 4.1_
  - [ ] 5.2 Create `config/rbac/assignments.php` — assign role `user` to user ID 1 (seeded admin)
    - _Requirements: 4.1, 4.3_
  - [ ] 5.3 Create `config/rbac/rules.php` — empty rules array (no custom rule classes needed)
    - _Requirements: 4.1_
  - [ ] 5.4 Create a Yii2 console command `commands/RbacController.php` with `actionInit` that seeds the admin user (username `admin`, hashed password) into the `user` table and writes RBAC files
    - _Requirements: 4.1, 4.3_

- [ ] 6. Authentication — LoginForm, SiteController, login view
  - [ ] 6.1 Update `models/LoginForm.php` — validate username/password against `User::findByUsername` and `validatePassword`; expose `getUser()`
    - _Requirements: 4.3, 4.4_
  - [ ] 6.2 Update `controllers/SiteController.php` — `actionIndex` (public landing), `actionLogin` (GET renders form, POST authenticates and redirects), `actionLogout` (POST, clears session), `actionError`
    - _Requirements: 4.3, 4.4, 4.5_
  - [ ] 6.3 Update `views/site/login.php` — render `LoginForm` with username/password fields and submit button using the custom CSS design system
    - _Requirements: 4.5_

- [ ] 7. AuthorController CRUD + views
  - [ ] 7.1 Create `controllers/AuthorController.php` — `AccessControl` behavior (index/view public; create/update/delete require `manageAuthors`); actions: `actionIndex`, `actionView`, `actionCreate`, `actionUpdate`, `actionDelete`
    - _Requirements: 2.2, 2.3, 2.4, 2.5, 3.4, 3.5, 4.2_
  - [ ] 7.2 Create `views/author/_form.php` — `ActiveForm` with `full_name` field and error display
    - _Requirements: 2.1, 2.3_
  - [ ] 7.3 Create `views/author/index.php` — paginated list using `ListView` or `GridView`; show full name; create button for authenticated users
    - _Requirements: 3.4_
  - [ ] 7.4 Create `views/author/view.php` — display full name, associated books list; show subscription form for guests (hide for authenticated users)
    - _Requirements: 2.6, 3.5, 5.1, 5.7_
  - [ ] 7.5 Create `views/author/create.php` and `views/author/update.php` — render `_form.php` with appropriate titles
    - _Requirements: 2.2, 2.5_

- [ ] 8. BookController CRUD + file upload + views
  - [ ] 8.1 Create `controllers/BookController.php` — `AccessControl` behavior (index/view public; create/update/delete require `manageBooks`); actions: `actionIndex`, `actionView`, `actionCreate`, `actionUpdate`, `actionDelete`; `actionCreate` calls `SmsPilotService::notifySubscribers()` on successful save
    - _Requirements: 1.2, 1.7, 1.8, 3.1, 3.2, 3.3, 4.2, 6.1, 6.2, 6.3_
  - [ ] 8.2 Create `views/book/_form.php` — `ActiveForm` with `enctype="multipart/form-data"`; fields: title, year, description, isbn, imageFile (file input), author multi-select (`listBox` or `checkboxList` from all authors); per-field error display
    - _Requirements: 1.1, 1.4, 1.5, 1.6, 1.10_
  - [ ] 8.3 Create `views/book/index.php` — paginated list; each card shows title, year, author names, cover thumbnail (`.cover-thumb`) or placeholder; create button for authenticated users
    - _Requirements: 3.1, 3.2, 9.3_
  - [ ] 8.4 Create `views/book/view.php` — display all book fields (title, year, description, ISBN, cover image, authors list)
    - _Requirements: 3.3_
  - [ ] 8.5 Create `views/book/create.php` and `views/book/update.php` — render `_form.php` with appropriate titles
    - _Requirements: 1.2, 1.8_

- [ ] 9. SubscriptionController + view
  - [ ] 9.1 Create `controllers/SubscriptionController.php` — POST-only `actionCreate`; load `SubscriptionForm` or direct `Subscription` model; validate phone; call `Subscription::findOrCreate()`; redirect back to author page with flash message
    - _Requirements: 5.2, 5.3, 5.5, 5.6_
  - [ ] 9.2 Create `views/author/_subscribe.php` partial — small form with phone input, submit button, and inline error; rendered inside `views/author/view.php` for guests only
    - _Requirements: 5.1, 5.6, 5.7_

- [ ] 10. ReportController + view
  - [ ] 10.1 Implement `models/ReportForm.php` — single `year` field; `rules()` validates integer in range 1000–2100
    - _Requirements: 7.2, 7.6_
  - [ ] 10.2 Create `controllers/ReportController.php` — public `actionIndex`; GET renders empty form; POST validates `ReportForm`, runs the top-10 query (JOIN `author`, `book_author`, `book` filtered by year, GROUP BY author, ORDER BY count DESC then name ASC, LIMIT 10), passes rows to view
    - _Requirements: 7.1, 7.2, 7.3, 7.4, 7.5, 7.6_
  - [ ] 10.3 Create `views/report/index.php` — year selection form; results table with columns: rank, full name, book count; empty-state message when no data
    - _Requirements: 7.2, 7.3, 7.5, 7.7_

- [ ] 11. SmsPilotService component
  - [ ] 11.1 Create `components/SmsPilotService.php` — extends `yii\base\Component`; public properties `$apiKey = 'DEMO'` and `$sender = 'INFORM'`; implement `buildMessage(string $bookTitle, string $authorName): string`; implement private `send(string $phone, string $message): ?array` (HTTP POST to `https://smspilot.ru/api2.php`, JSON body, try/catch, log on error); implement `notifySubscribers(Book $book): void` (load subscriptions for all book authors, call `send()` per phone, log errors, never throw)
    - _Requirements: 6.3, 6.4, 6.5, 6.6, 6.7_

- [ ] 12. Wire SMS notification into BookController
  - [ ] 12.1 In `BookController::actionCreate`, after `$model->save()` returns true, call `Yii::$app->smsPilot->notifySubscribers($model)`; ensure book creation is never rolled back on SMS failure
    - _Requirements: 6.1, 6.2, 6.3, 6.5_

- [ ] 13. Layout and custom CSS design system
  - [ ] 13.1 Update `views/layouts/main.php` — navigation bar with app name, links (Catalog, Authors, Report), conditional username + logout link for authenticated users, login link for guests; main content area; footer
    - _Requirements: 4.5, 4.6, 9.1_
  - [ ] 13.2 Write `web/css/site.css` — implement the full design system: color palette (`#2C3E50`, `#E74C3C`, `#F8F9FA`), Inter font via Google Fonts, `.card`, `.cover-thumb` (80×120px object-fit), `.alert-success`/`.alert-danger` (left-border flash), `.btn-primary` (accent red), responsive CSS Grid (3 cols ≥992px, 2 cols ≥576px, 1 col below)
    - _Requirements: 9.1, 9.2, 9.3, 9.5_
  - [ ] 13.3 Update `assets/AppAsset.php` — register `web/css/site.css`; remove default Bootstrap CSS if replaced by custom stylesheet
    - _Requirements: 9.2_

- [ ] 14. Polish all views — author, book, report, subscription
  - [ ] 14.1 Apply `.card` layout and `.cover-thumb` to `views/book/index.php` and `views/book/view.php`
    - _Requirements: 9.2, 9.3_
  - [ ] 14.2 Apply consistent card/table styling to `views/author/index.php`, `views/author/view.php`, and `views/report/index.php`
    - _Requirements: 9.1, 9.2_
  - [ ] 14.3 Ensure all forms use `.btn-primary` and display per-field validation errors inline
    - _Requirements: 1.3, 2.3, 5.3, 7.6, 9.2_

- [ ] 15. Flash messages and error pages
  - [ ] 15.1 Add `Yii::$app->session->setFlash('success', ...)` and `setFlash('error', ...)` calls in `BookController`, `AuthorController`, and `SubscriptionController` after create, update, and delete operations
    - _Requirements: 9.4_
  - [ ] 15.2 Render flash messages in `views/layouts/main.php` using `.alert-success` / `.alert-danger` CSS classes
    - _Requirements: 9.4_
  - [ ] 15.3 Update `views/site/error.php` — apply custom layout and design system styling
    - _Requirements: 9.1_

- [ ] 16. Checkpoint — verify full application flow
  - Run `php yii migrate` on a clean DB, seed admin via `php yii rbac/init`, log in, create an author, create a book with cover image, subscribe as guest, check report page. Ensure all tests pass, ask the user if questions arise.

- [ ] 17. Property-based tests (eris) for all 14 correctness properties
  - [ ] 17.1 Add `giorgiosironi/eris` to `composer.json` (dev dependency); create `tests/unit/properties/` directory; configure `tests/unit.suite.yml` to include the properties namespace
    - _Requirements: (test infrastructure)_
  - [ ]* 17.2 Write `tests/unit/properties/IsbnRoundTripTest.php` — Property 1: generate valid ISBN-10/13 strings with random hyphens, assert `normalize()` is idempotent and `isValid()` returns true
    - **Property 1: ISBN Round-Trip Normalization**
    - **Validates: Requirements 10.1, 10.2, 10.3, 10.4**
  - [ ]* 17.3 Write `tests/unit/properties/IsbnInvalidCheckTest.php` — Property 2: generate valid ISBNs, corrupt the last digit, assert `IsbnValidator` rejects them
    - **Property 2: ISBN Rejection of Invalid Check Digits**
    - **Validates: Requirements 1.4, 10.5**
  - [ ]* 17.4 Write `tests/unit/properties/BookPersistenceTest.php` — Property 3: generate random title/year/description, save `Book`, reload from DB, assert field equality
    - **Property 3: Book Persistence Round-Trip**
    - **Validates: Requirements 1.1, 1.2, 1.8**
  - [ ]* 17.5 Write `tests/unit/properties/ModelValidationTest.php` — Property 4: generate `Book` with null title or year and `Author` with empty name, assert `validate()` returns false with errors on the missing field
    - **Property 4: Required-Field Validation Rejection**
    - **Validates: Requirements 1.3, 2.3**
  - [ ]* 17.6 Write `tests/unit/properties/DeleteCascadeTest.php` — Property 5: generate book with 1–5 authors, delete book, assert zero `book_author` rows; repeat for author deletion
    - **Property 5: Delete Cascades Join Records**
    - **Validates: Requirements 1.7, 2.4**
  - [ ]* 17.7 Write `tests/unit/properties/SubscriptionIdempotencyTest.php` — Property 6: generate random `(author_id, phone)`, call `findOrCreate` 2–5 times, assert exactly one DB row
    - **Property 6: Idempotent Subscription**
    - **Validates: Requirements 5.5, 8.5**
  - [ ]* 17.8 Write `tests/unit/properties/PhoneValidationTest.php` — Property 7: generate strings matching and not matching `/^\+?\d{10,15}$/`, assert `Subscription::validate()` result accordingly
    - **Property 7: Phone Number Validation**
    - **Validates: Requirements 5.3, 5.4**
  - [ ]* 17.9 Write `tests/unit/properties/SmsMessageTest.php` — Property 8: generate random book title and author name, assert `buildMessage()` output contains both as substrings
    - **Property 8: SMS Message Content**
    - **Validates: Requirements 6.6**
  - [ ]* 17.10 Write `tests/unit/properties/SmsRecipientTest.php` — Property 9: generate book with N authors each having M_i subscribers (mocked), assert `notifySubscribers()` calls `send()` exactly Σ M_i times
    - **Property 9: SMS Recipient Collection**
    - **Validates: Requirements 6.1, 6.2, 6.3**
  - [ ]* 17.11 Write `tests/unit/properties/ReportOrderingTest.php` — Property 10: generate random author/book/year dataset, run report query, assert ≤10 rows ordered by count DESC then name ASC
    - **Property 10: Report Ordering**
    - **Validates: Requirements 7.3, 7.4**
  - [ ]* 17.12 Write `tests/unit/properties/ReportFormValidationTest.php` — Property 11: generate non-integer and out-of-range year values, assert `ReportForm::validate()` returns false
    - **Property 11: Report Validation Rejection**
    - **Validates: Requirements 7.6**
  - [ ]* 17.13 Write `tests/unit/properties/CoverPathTest.php` — Property 12: generate valid image file mocks, call `Book::save()`, assert `cover_path` is non-empty and file exists under `web/uploads/covers/`
    - **Property 12: Cover Image Path Persistence**
    - **Validates: Requirements 1.5**
  - [ ]* 17.14 Write `tests/unit/properties/NonImageUploadTest.php` — Property 13: generate files with non-image MIME types, assert `Book::validate()` returns false with error on the cover field
    - **Property 13: Non-Image Upload Rejection**
    - **Validates: Requirements 1.6**
  - [ ]* 17.15 Write `tests/unit/properties/AccessControlTest.php` — Property 14: for each protected action (create/update/delete on Book and Author), send unauthenticated request, assert HTTP 302 redirect to login URL
    - **Property 14: Access Control Redirect**
    - **Validates: Requirements 4.2**

- [ ] 18. README and final cleanup
  - [ ] 18.1 Rewrite `README.md` — project description, requirements (PHP 8+, Composer, MySQL), setup steps (`composer install`, configure `config/db.php`, `php yii migrate`, `php yii rbac/init`), how to run tests (`vendor/bin/codecept run unit`)
    - _Requirements: 8.2_
  - [ ] 18.2 Final cleanup — remove any remaining Yii2 demo references, verify `.gitignore` covers `config/db.php`, `web/uploads/covers/*`, `runtime/`, `vendor/`
    - _Requirements: 8.2_

- [ ] 19. Final checkpoint — Ensure all tests pass
  - Run `vendor/bin/codecept run unit`. Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for a faster MVP
- Each task references specific requirements for traceability
- Property tests (task 17) require `giorgiosironi/eris` and a test DB configured in `config/test_db.php`
- SMS tasks (11, 12) are core but the DEMO key means no real messages are sent during development
- Checkpoints (16, 19) are manual verification gates before moving to the next phase
