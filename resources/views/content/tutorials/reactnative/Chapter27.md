# Chapter 27: Code Quality & Refactoring

---

In previous chapters, we built several ExpenseApp features using:

- Navigation
- Context API
- AsyncStorage
- APIs
- Forms & Validation
- Expo Router
- TypeScript
- Testing
- Debugging

As applications grow larger, maintaining clean and scalable code becomes extremely important.

Without proper code quality practices:

❌ Components become too large

❌ Logic gets duplicated

❌ Bugs increase

❌ Debugging becomes difficult

❌ New developers struggle to understand the codebase

Modern React Native applications solve these problems using:

✅ Consistent coding standards

✅ Refactoring techniques

✅ Reusable architecture

✅ Linting and formatting tools

In this chapter, we will improve the quality, readability, and maintainability of ExpenseApp.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand why code quality matters
- Configure ESLint and Prettier
- Apply coding standards
- Organize scalable folder structures
- Extract reusable hooks and utilities
- Follow naming conventions
- Reduce code duplication
- Refactor React Native components safely

---

# ⚡ Why Code Quality Matters

Good code quality improves:

✅ Readability

✅ Maintainability

✅ Scalability

✅ Team collaboration

✅ Debugging

---

# 🔹 Without Good Code Quality

Applications often suffer from:

❌ Inconsistent styles

❌ Repeated logic

❌ Large components

❌ Difficult onboarding

❌ Increased bugs

---

# 🔹 With Good Code Quality

Applications become:

✅ Cleaner

✅ Easier to extend

✅ Easier to debug

✅ Easier to test

---

# 🔹 Real ExpenseApp Example

Imagine:

- 20+ screens
- Multiple developers
- APIs
- Theme support
- Authentication
- Transactions
- Analytics

Without proper structure, the project quickly becomes difficult to manage.

---

# 🧹 ESLint Setup

---

# 🔹 What is ESLint?

ESLint identifies:

✅ Code issues

✅ Bad practices

✅ Style inconsistencies

---

# 🔹 Why Important?

ESLint helps prevent:

❌ Unused variables

❌ Incorrect hooks usage

❌ Accidental mistakes

---

# 🔹 Install ESLint

```bash id="eslint001"
npm install --save-dev eslint
```

---

# 🔹 Initialize ESLint

```bash id="eslint002"
npx eslint --init
```

---

# 🔹 Basic ESLint Configuration

📁 `.eslintrc.json`

```json id="eslint003"
{
    "extends": ["eslint:recommended", "plugin:react/recommended"]
}
```

---

# 🔹 ESLint Benefits

Benefits:

✅ Detects errors early

✅ Improves consistency

✅ Encourages best practices

---

# 🔹 Example Warning

```ts id="eslint004"
const data = 10;
```

Unused variable warning helps clean unnecessary code.

---

# 🎨 Prettier Setup

---

# 🔹 What is Prettier?

Prettier automatically formats code consistently.

---

# 🔹 Why Useful?

Instead of manually formatting:

❌ Indentation

❌ Quotes

❌ Line spacing

Prettier formats automatically.

---

# 🔹 Install Prettier

```bash id="prettier001"
npm install --save-dev prettier
```

---

# 🔹 Prettier Configuration

📁 `.prettierrc`

```json id="prettier002"
{
    "semi": true,
    "singleQuote": true,
    "trailingComma": "all"
}
```

---

# 🔹 Benefits

✅ Consistent formatting

✅ Better readability

✅ Saves development time

---

# 🔹 ESLint + Prettier Together

Use both together:

| Tool     | Purpose         |
| -------- | --------------- |
| ESLint   | Code quality    |
| Prettier | Code formatting |

---

# 📁 Scalable Folder Structure

As applications grow, proper structure becomes essential.

---

# 🔹 Recommended ExpenseApp Structure

```text id="folder001"
src
│
├── app
├── components
├── hooks
├── services
├── contexts
├── utils
├── constants
├── types
├── styles
```

---

# 🔹 Why This Structure Works

Benefits:

✅ Better organization

✅ Easier navigation

✅ Better scalability

✅ Cleaner architecture

---

# 🔹 Folder Responsibilities

| Folder     | Purpose          |
| ---------- | ---------------- |
| app        | Screens & routes |
| components | Reusable UI      |
| hooks      | Reusable logic   |
| services   | APIs             |
| utils      | Helper functions |
| contexts   | Global state     |

---

# 🪝 Extracting Reusable Hooks

Hooks help separate logic from UI.

---

# 🔹 Problem Before Refactoring

```tsx id="hook001"
useEffect(() => {
    fetchTransactions();
}, []);
```

This logic may repeat in multiple screens.

---

# 🔹 Better Approach

📁 `src/hooks/use-transactions.ts`

```tsx id="hook002"
import { useEffect, useState } from "react";

export default function useTransactions() {
    const [transactions, setTransactions] = useState([]);

    useEffect(() => {
        loadTransactions();
    }, []);

    const loadTransactions = async () => {
        // Fetch data
    };

    return {
        transactions,
    };
}
```

---

# 🔹 Benefits of Custom Hooks

✅ Reusable logic

✅ Cleaner components

✅ Easier testing

✅ Better maintainability

---

# 🔹 Cleaner Screen Example

```tsx id="hook003"
const { transactions } = useTransactions();
```

Much cleaner than repeating API logic everywhere.

---

# 🧩 Extracting Utilities

Utilities contain reusable helper functions.

---

# 🔹 What Should Go Into utils?

Examples:

✅ Formatting

✅ Calculations

✅ Date helpers

✅ Validation helpers

---

# 🔹 Example Utility

📁 `src/utils/calculate-total.ts`

```ts id="util001"
export const calculateTotal = (transactions) => {
    return transactions.reduce((sum, item) => sum + item.amount, 0);
};
```

---

# 🔹 ExpenseApp Usage

```ts id="util002"
const total = calculateTotal(transactions);
```

---

# 🔹 Why Utilities Matter

Benefits:

✅ Reusable logic

✅ Reduced duplication

✅ Easier maintenance

---

# 🔤 Naming Conventions

Consistent naming improves readability significantly.

---

# 🔹 Recommended Naming Rules

| Item       | Convention        |
| ---------- | ----------------- |
| Components | PascalCase        |
| Functions  | camelCase         |
| Hooks      | useSomething      |
| Constants  | UPPER_CASE        |
| Files      | Consistent naming |

---

# 🔹 Examples

```ts id="name001"
const calculateTotal = () => {};

const MAX_LIMIT = 1000;
```

---

# 🔹 ExpenseApp Examples

✅ `TransactionItem.tsx`

✅ `useTransactions.ts`

✅ `calculate-total.ts`

---

# 🔁 Reducing Code Duplication

Repeated code increases maintenance difficulty.

---

# 🔹 Problem Example

```tsx id="dup001"
<Text>{item.title}</Text>

<Text>{item.amount}</Text>
```

Repeated across multiple screens.

---

# 🔹 Better Approach

Create reusable component.

📁 `src/components/transaction-item.tsx`

```tsx id="dup002"
type Props = {
    title: string;
    amount: number;
};

export default function TransactionItem({ title, amount }: Props) {
    return (
        <Text>
            {title}: ₹{amount}
        </Text>
    );
}
```

---

# 🔹 DRY Principle

DRY means:

```text id="dry001"
Don't Repeat Yourself
```

---

# 🔹 Benefits

✅ Less duplication

✅ Easier updates

✅ Cleaner architecture

---

# 🧪 ExpenseApp Refactoring Example

---

# 🔹 Before Refactoring

❌ API logic inside screen

❌ Repeated calculations

❌ Repeated form logic

❌ Large components

---

# 🔹 After Refactoring

✅ APIs moved to services

✅ Hooks extracted

✅ Utilities reused

✅ Components simplified

---

# 🔹 Result

Application becomes:

✅ Cleaner

✅ Easier to test

✅ Easier to scale

---

# ⚡ Refactoring Strategies

Refactoring should be gradual and safe.

---

# 🔹 Small Steps

✅ Refactor incrementally

❌ Avoid rewriting everything together

---

# 🔹 Keep Application Working

After every refactor:

✅ Test functionality

✅ Verify UI

✅ Run application

---

# 🔹 Improve Readability

Examples:

✅ Better variable names
✅ Smaller functions
✅ Smaller components

---

# 🔹 Extract Reusable Logic

Move reusable logic into:

✅ hooks
✅ utils
✅ services

---

# 🔹 Keep Components Focused

Large components are difficult to maintain.

Prefer:

✅ Smaller reusable components

---

# ⚠️ Common Mistakes

❌ Over-refactoring
❌ Breaking working code
❌ Ignoring naming conventions
❌ Large monolithic components
❌ Keeping duplicated logic

---

# ✅ Best Practices

✅ Use ESLint + Prettier
✅ Keep folder structure organized
✅ Extract reusable hooks
✅ Extract utilities
✅ Follow naming conventions
✅ Apply DRY principle
✅ Refactor regularly

---

# 🧪 Practice Exercises

1. Extract transaction API into service
2. Create reusable TransactionItem component
3. Create useTransactions hook
4. Move calculations into utils
5. Add ESLint configuration
6. Add Prettier configuration
7. Refactor large screen into smaller components

---

# 📘 Chapter Summary

In this chapter, you:

✅ Improved code quality practices
✅ Configured ESLint and Prettier
✅ Organized scalable folder structure
✅ Extracted reusable hooks and utilities
✅ Applied naming conventions
✅ Reduced code duplication
✅ Learned safe refactoring strategies
✅ Improved ExpenseApp maintainability
