# Account Model - Overview

## Description
This model represents the `multiuser_accounts` table in the database. It stores information related to multi-user accounts, including the master user, company name, and timestamps for account creation and update.

---

## Properties

### id
- **Type**: Integer
- **Description**: Unique identifier for the account.
- **Description (Russian)**: Уникальный идентификатор аккаунта.
  
### masterUser
- **Type**: `\Shopware\Models\Customer\Customer`
- **Description**: Reference to the master user (Shopware customer) who controls the account.
- **Description (Russian)**: Ссылка на основного пользователя (покупателя Shopware), управляющего аккаунтом.
  
### companyName
- **Type**: String
- **Description**: Name of the company associated with the account.
- **Description (Russian)**: Название компании, связанной с аккаунтом.
  
### createdAt
- **Type**: DateTime
- **Description**: Timestamp when the account was created.
- **Description (Russian)**: Время, когда был создан аккаунт.
  
### updatedAt
- **Type**: DateTime
- **Description**: Timestamp when the account was last updated.
- **Description (Russian)**: Время, когда аккаунт был в последний раз обновлен.

---

## Relationships
- **masterUser**: Many-to-One relationship with the `Customer` model (Shopware).
  - **masterUser (Russian)**: Связь многие к одному с моделью `Customer` (Shopware).
