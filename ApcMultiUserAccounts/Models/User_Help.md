# Model: User

## Description

The `User` model represents the users associated with a specific account. Each user has a role and a status and is linked to an existing customer from Shopware. This model tracks the user's creation and update times.

## Fields

### `id`
- **Type:** Integer
- **Description:** The unique identifier for the user.
- **Примечание:** Уникальный идентификатор пользователя.

### `account`
- **Type:** ManyToOne (Relationship to `Account` model)
- **Description:** Reference to the associated account. Each user belongs to a specific account.
- **Примечание:** Ссылка на связанный аккаунт. Каждый пользователь привязан к конкретному аккаунту.

### `user`
- **Type:** ManyToOne (Relationship to `Customer` model from Shopware)
- **Description:** Reference to the Shopware customer that represents the user.
- **Примечание:** Ссылка на пользователя (клиента) из Shopware.

### `role`
- **Type:** ManyToOne (Relationship to `Role` model)
- **Description:** The role assigned to the user (e.g., Admin, Buyer, etc.).
- **Примечание:** Роль, назначенная пользователю (например, Админ, Покупатель и т.д.).

### `status`
- **Type:** ManyToOne (Relationship to `Status` model)
- **Description:** The status of the user (Active, Inactive, etc.).
- **Примечание:** Статус пользователя (Активен, Неактивен и т.д.).

### `createdAt`
- **Type:** Datetime
- **Description:** The date and time when the user was created.
- **Примечание:** Дата и время создания пользователя.

### `updatedAt`
- **Type:** Datetime
- **Description:** The date and time when the user was last updated.
- **Примечание:** Дата и время последнего обновления пользователя.

## Relationships
- **Account:** A user is associated with one account.
- **Shopware Customer:** A user is linked to a customer entity in Shopware.
- **Role:** A user has one role that determines their permissions.
- **Status:** A user has a status that indicates their current state (active, inactive, etc.).

## Example Usage

```php
$user = new User();
$user->setAccount($account);  // Link to an account
$user->setUser($shopwareCustomer);  // Link to a Shopware customer
$user->setRole($role);  // Assign a role to the user
$user->setStatus($status);  // Assign a status to the user
$user->setCreatedAt(new \DateTime());  // Set creation date
$user->setUpdatedAt(new \DateTime());  // Set update date

$entityManager->persist($user);
$entityManager->flush();
