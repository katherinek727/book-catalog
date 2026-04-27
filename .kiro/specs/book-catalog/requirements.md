# Requirements Document

## Introduction

A web-based book catalog application built on PHP 8+, Yii2 Basic, and MySQL/MariaDB.
The application allows guests to browse books and authors, subscribe to author updates via phone number,
and allows authenticated users to fully manage the catalog. An optional SMS notification feature
alerts subscribers when a new book is added by an author they follow.

## Glossary

- **System**: The book catalog web application as a whole
- **Book**: An entity with a title, publication year, description, ISBN, and optional cover image
- **Author**: An entity representing a person with a full name (ФИО)
- **Catalog**: The browsable list of all books in the system
- **Guest**: An unauthenticated visitor of the application
- **AuthenticatedUser**: A user who has successfully logged in
- **Subscription**: A record linking a phone number to an Author for SMS notifications
- **Subscriber**: A Guest who has submitted a phone number to follow an Author
- **SmsPilot**: The third-party SMS gateway used to deliver notifications (APIKEY=DEMO)
- **RBAC**: Role-Based Access Control, implemented via Yii2 file-based RBAC
- **ISBN**: International Standard Book Number — a unique 10- or 13-digit book identifier
- **CoverImage**: An image file uploaded locally representing the book's cover
- **ReportPage**: A page listing the top 10 authors by book count for a given year
- **Migration**: A Yii2 database migration file used to create or alter database schema

---

## Requirements

### Requirement 1: Book Entity Management

**User Story:** As an AuthenticatedUser, I want to create, edit, and delete books, so that I can maintain an accurate and up-to-date catalog.

#### Acceptance Criteria

1. THE System SHALL store each Book with the following fields: title (string, required), year (integer, required), description (text, optional), ISBN (string, optional), and CoverImage (file, optional).
2. WHEN an AuthenticatedUser submits a valid book creation form, THE System SHALL persist the Book to the database and redirect to the book detail page.
3. WHEN an AuthenticatedUser submits a book creation form with a missing required field, THE System SHALL display a validation error message for each missing field without persisting the record.
4. WHEN an AuthenticatedUser submits a book form with an ISBN value, THE System SHALL validate that the ISBN conforms to ISBN-10 or ISBN-13 format and display an error if it does not.
5. WHEN an AuthenticatedUser uploads a CoverImage, THE System SHALL store the file on the local filesystem under `web/uploads/covers/` and save the relative path in the database.
6. WHEN an AuthenticatedUser submits a book form with a CoverImage that is not an image MIME type, THE System SHALL reject the upload and display a validation error.
7. WHEN an AuthenticatedUser requests to delete a Book, THE System SHALL remove the Book record, all BookAuthor join records for that Book, and the associated CoverImage file from the filesystem.
8. WHEN an AuthenticatedUser submits a valid book edit form, THE System SHALL update the existing Book record and reflect changes immediately on the detail page.
9. THE System SHALL associate each Book with one or more Authors via a many-to-many relationship stored in a `book_author` join table.
10. WHEN an AuthenticatedUser creates or edits a Book, THE System SHALL present a multi-select input listing all existing Authors for assignment.

---

### Requirement 2: Author Entity Management

**User Story:** As an AuthenticatedUser, I want to create, edit, and delete authors, so that I can keep author information accurate.

#### Acceptance Criteria

1. THE System SHALL store each Author with a full name field (ФИО, string, required).
2. WHEN an AuthenticatedUser submits a valid author creation form, THE System SHALL persist the Author to the database and redirect to the author detail page.
3. WHEN an AuthenticatedUser submits an author creation form with an empty full name, THE System SHALL display a validation error without persisting the record.
4. WHEN an AuthenticatedUser requests to delete an Author, THE System SHALL remove the Author record and all associated BookAuthor join records.
5. WHEN an AuthenticatedUser submits a valid author edit form, THE System SHALL update the existing Author record and reflect changes immediately.
6. THE System SHALL display on each Author detail page the list of Books associated with that Author.

---

### Requirement 3: Book Catalog — Public View

**User Story:** As a Guest, I want to browse the book catalog, so that I can discover books without needing an account.

#### Acceptance Criteria

1. THE System SHALL display a paginated list of all Books accessible to any visitor without authentication.
2. THE System SHALL display for each Book in the list: title, year, author names, and CoverImage thumbnail (or a placeholder if no image is set).
3. WHEN a visitor navigates to a Book detail page, THE System SHALL display all Book fields: title, year, description, ISBN, CoverImage, and the list of associated Authors.
4. THE System SHALL display a paginated list of all Authors accessible to any visitor without authentication.
5. WHEN a visitor navigates to an Author detail page, THE System SHALL display the Author's full name and the list of Books associated with that Author.

---

### Requirement 4: Access Control

**User Story:** As a system administrator, I want role-based access control enforced, so that only authenticated users can modify catalog data.

#### Acceptance Criteria

1. THE System SHALL implement access control using Yii2 file-based RBAC with at least two roles: `guest` and `user`.
2. WHEN a Guest attempts to access a create, edit, or delete action for Books or Authors, THE System SHALL redirect the Guest to the login page.
3. WHEN an AuthenticatedUser logs in with valid credentials, THE System SHALL grant access to all CRUD actions for Books and Authors.
4. WHEN an AuthenticatedUser logs in with invalid credentials, THE System SHALL display an authentication error and remain on the login page.
5. THE System SHALL provide a login page and a logout action accessible from the main navigation.
6. WHILE an AuthenticatedUser is logged in, THE System SHALL display the username and a logout link in the navigation bar.

---

### Requirement 5: Author Subscription (Guest)

**User Story:** As a Guest, I want to subscribe to an author using my phone number, so that I receive an SMS when a new book by that author is added.

#### Acceptance Criteria

1. THE System SHALL display a subscription form on each Author detail page accessible to Guests.
2. WHEN a Guest submits the subscription form with a valid phone number, THE System SHALL persist a Subscription record linking the phone number to the Author.
3. WHEN a Guest submits the subscription form with an empty or malformed phone number, THE System SHALL display a validation error without persisting the record.
4. THE System SHALL validate phone numbers as containing 10–15 digits, optionally prefixed with `+`.
5. WHEN a Guest submits a subscription form for an Author with a phone number that already has an active Subscription for that Author, THE System SHALL silently accept the submission without creating a duplicate record (idempotent subscription).
6. THE System SHALL NOT require a Guest to register or authenticate in order to subscribe.
7. WHILE an AuthenticatedUser is logged in, THE System SHALL hide the subscription form on Author detail pages.

---

### Requirement 6: SMS Notification on New Book

**User Story:** As a Subscriber, I want to receive an SMS when a new book is added by an author I follow, so that I stay informed about new publications.

#### Acceptance Criteria

1. WHEN a new Book is successfully created and saved, THE System SHALL identify all Authors associated with that Book.
2. WHEN a new Book is successfully created, THE System SHALL retrieve all Subscriptions for each associated Author.
3. WHEN Subscriptions exist for an Author of a newly created Book, THE System SHALL send an SMS notification to each Subscriber's phone number via the SmsPilot API.
4. THE SmsPilot integration SHALL use the configured APIKEY (defaulting to `DEMO`) from application params.
5. WHEN the SmsPilot API returns an error response for a given phone number, THE System SHALL log the error and continue processing remaining Subscriptions without interrupting the book creation flow.
6. THE SMS message SHALL include the Book title and the Author's full name.
7. WHERE the SmsPilot APIKEY is set to `DEMO`, THE System SHALL use the SmsPilot emulator endpoint and SHALL NOT send real SMS messages.

---

### Requirement 7: Report Page — Top Authors by Year

**User Story:** As a visitor, I want to see a report of the most prolific authors for a given year, so that I can discover popular authors.

#### Acceptance Criteria

1. THE System SHALL provide a ReportPage accessible to all visitors without authentication.
2. THE ReportPage SHALL display a form allowing the visitor to select or enter a publication year.
3. WHEN a visitor submits the ReportPage form with a valid year, THE System SHALL query the database and display the top 10 Authors ordered by the count of Books published in that year, descending.
4. WHEN two Authors have the same book count for the selected year, THE System SHALL order them alphabetically by full name as a tiebreaker.
5. WHEN no Books exist for the selected year, THE System SHALL display an informational message indicating no data is available for that year.
6. WHEN a visitor submits the ReportPage form with an invalid or missing year, THE System SHALL display a validation error.
7. THE ReportPage SHALL display for each Author in the result: rank, full name, and book count for the selected year.

---

### Requirement 8: Database Migrations

**User Story:** As a developer, I want database migrations for all schema changes, so that the project can be set up reproducibly without a DB dump.

#### Acceptance Criteria

1. THE System SHALL provide Yii2 Migration files for all database tables: `book`, `author`, `book_author`, and `subscription`.
2. THE System SHALL NOT include a database dump; all schema setup SHALL be achievable by running `yii migrate`.
3. WHEN `yii migrate` is executed on a clean database, THE System SHALL create all required tables with correct column types, constraints, and indexes.
4. THE `book_author` Migration SHALL define a composite primary key on `(book_id, author_id)` with foreign keys referencing `book` and `author`.
5. THE `subscription` Migration SHALL define a unique constraint on `(author_id, phone)` to enforce idempotent subscriptions at the database level.

---

### Requirement 9: UI Design

**User Story:** As a visitor, I want a modern and distinctive UI, so that the application is pleasant and easy to use.

#### Acceptance Criteria

1. THE System SHALL use a consistent layout with a navigation bar, main content area, and footer on all pages.
2. THE System SHALL apply a modern CSS framework or custom stylesheet that provides a visually distinctive design beyond the default Yii2 Bootstrap theme.
3. THE System SHALL display CoverImage thumbnails in the book list with uniform dimensions and graceful fallback for missing images.
4. THE System SHALL display flash messages (success, error) using styled alert components after create, update, and delete operations.
5. THE System SHALL be responsive and render correctly on both desktop and mobile viewport widths.

---

### Requirement 10: ISBN Parsing and Validation (Round-Trip)

**User Story:** As a developer, I want ISBN validation to be reliable and round-trippable, so that stored ISBNs are always in a canonical form.

#### Acceptance Criteria

1. THE System SHALL normalize ISBNs to a canonical hyphen-free digit string upon saving.
2. WHEN an ISBN-10 value is provided, THE System SHALL validate the check digit using the standard ISBN-10 algorithm.
3. WHEN an ISBN-13 value is provided, THE System SHALL validate the check digit using the standard ISBN-13 (EAN-13) algorithm.
4. FOR ALL valid ISBN strings (with or without hyphens), parsing then normalizing then formatting SHALL produce an equivalent canonical representation (round-trip property).
5. WHEN an invalid ISBN check digit is detected, THE System SHALL display a descriptive validation error identifying the field and the nature of the failure.
