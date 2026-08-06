# Chapter 21: TypeScript Fundamentals for React Native

---

In previous chapters, we built several ExpenseApp features using:

- Navigation
- Context API
- AsyncStorage
- APIs
- Notifications
- Device APIs
- Animations

As applications grow larger, managing code safely becomes more difficult.

Large applications often face problems such as:

❌ Runtime errors
❌ Incorrect data types
❌ Difficult debugging
❌ Poor maintainability

To solve these issues, modern React Native applications use:

✅ TypeScript

TypeScript helps developers write safer, cleaner, and more scalable applications.

In this chapter, we will learn TypeScript fundamentals using real-world ExpenseApp examples.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand why TypeScript is important
- Use basic TypeScript types
- Create interfaces and custom types
- Understand `type` vs `interface`
- Use union types
- Use generics
- Type React Native components properly
- Type hooks and functions safely
- Configure TypeScript correctly

---

# ⚡ What is TypeScript?

TypeScript is a superset of JavaScript.

It adds:

✅ Static typing
✅ Better tooling
✅ Better auto-completion
✅ Better error detection

TypeScript code eventually converts into normal JavaScript.

---

# 🔹 Why TypeScript Matters

Without TypeScript:

❌ Errors appear during runtime

❌ Difficult debugging

❌ Unsafe code changes

With TypeScript:

✅ Errors detected early

✅ Safer refactoring

✅ Better scalability

✅ Better developer productivity

---

# 🔹 ExpenseApp Example

Imagine:

- Thousands of expenses
- Multiple developers
- APIs
- Context state
- Complex navigation

Without TypeScript, maintaining the application becomes difficult.

TypeScript helps maintain consistency across the entire application.

---

# 🧪 JavaScript vs TypeScript

---

# ❌ JavaScript Example

```js
function add(a, b) {
    return a + b;
}

add(10, "20");
```

Possible result:

```text
1020
```

Unexpected behavior occurs because JavaScript allows mixing types.

---

# ✅ TypeScript Example

```ts
function add(a: number, b: number): number {
    return a + b;
}
```

Now invalid usage produces TypeScript errors before runtime.

---

# 🔹 Basic TypeScript Types

---

# 🔹 String

```ts
let description: string = "Food";
```

---

# 🔹 Number

```ts
let amount: number = 250;
```

---

# 🔹 Boolean

```ts
let isPaid: boolean = true;
```

---

# 🔹 Arrays

```ts
let expenses: number[] = [100, 200, 300];
```

---

# 🔹 Object Types

```ts
let expense: {
    description: string;
    amount: number;
} = {
    description: "Food",
    amount: 200,
};
```

---

# 🔹 Avoid any Type

```ts
let data: any = "Hello";
```

Using `any` disables type safety.

Avoid it whenever possible.

---

# 🔹 Why Avoid any?

Using `any`:

❌ Removes TypeScript protection

❌ Hides errors

❌ Reduces maintainability

---

# 🧩 Interfaces

Interfaces define object structure.

They help maintain consistent data models.

---

# 🔹 Expense Interface

```ts
interface Expense {
    id: number;
    description: string;
    amount: number;
}
```

---

# 🔹 Using Interface

```ts
const expense: Expense = {
    id: 1,
    description: "Food",
    amount: 250,
};
```

---

# 🔹 ExpenseApp Example

```ts
const expenses: Expense[] = [
    {
        id: 1,
        description: "Food",
        amount: 250,
    },
];
```

---

# 🔹 Why Interfaces Matter

Benefits:

✅ Consistent data structure

✅ Better readability

✅ Safer API integration

✅ Easier maintenance

---

# 🔹 Optional Properties

Some properties may not always exist.

---

## Example

```ts
interface Expense {
    id: number;
    description: string;
    amount: number;
    receiptUri?: string;
}
```

The `?` makes property optional.

---

# 🔹 Readonly Properties

```ts
interface Expense {
    readonly id: number;
    description: string;
}
```

Readonly properties cannot be modified later.

---

# 🔹 Extending Interfaces

Interfaces can inherit other interfaces.

---

## Example

```ts
interface BaseExpense {
    id: number;
    amount: number;
}

interface FoodExpense extends BaseExpense {
    restaurant: string;
}
```

---

# 🔹 type vs interface

Both are used for defining structures.

---

# 🔹 Using type

```ts
type Expense = {
    id: number;
    description: string;
    amount: number;
};
```

---

# 🔹 Main Differences

| Feature       | interface | type           |
| ------------- | --------- | -------------- |
| Best for      | Objects   | Flexible types |
| Extendable    | Yes       | Yes            |
| Union support | Limited   | Excellent      |

---

# 🔹 Recommended Usage

Use:

✅ `interface` for objects

✅ `type` for unions and advanced structures

---

# 🔹 Union Types

Union types allow multiple possible values.

---

# 🔹 Example

```ts
let status: "pending" | "paid" | "failed";
```

---

# 🔹 ExpenseApp Example

```ts
type Category = "food" | "travel" | "shopping";
```

---

# 🔹 Why Useful?

Benefits:

✅ Restricts invalid values

✅ Improves safety

✅ Improves readability

---

# 🔹 Type Inference

TypeScript automatically detects types.

---

# 🔹 Example

```ts
let amount = 500;
```

Automatically inferred as:

```ts
number;
```

---

# 🔹 When Explicit Types Are Better

Explicit typing is recommended for:

✅ Function parameters

✅ API responses

✅ Complex objects

✅ Shared models

---

# 🧠 Generics

Generics create reusable and type-safe code.

---

# 🔹 Basic Generic Example

```ts
function identity<T>(value: T): T {
    return value;
}
```

---

# 🔹 Usage

```ts
identity<number>(10);

identity<string>("Hello");
```

---

# 🔹 ExpenseApp Example

```ts
function getFirstItem<T>(items: T[]): T {
    return items[0];
}
```

---

# 🔹 Why Generics Matter

Benefits:

✅ Reusable code

✅ Better flexibility

✅ Strong type safety

---

# ⚛️ Typing React Components

---

# 🔹 Props Typing

📁 `src/components/expense-item.tsx`

```tsx
type Props = {
    description: string;
    amount: number;
};

export default function ExpenseItem({ description, amount }: Props) {
    return (
        <Text>
            {description}: ₹{amount}
        </Text>
    );
}
```

---

# 🔹 Using interface for Props

```tsx
interface ExpenseItemProps {
    description: string;
    amount: number;
}

const ExpenseItem = ({ description, amount }: ExpenseItemProps) => {
    return (
        <Text>
            {description}: ₹{amount}
        </Text>
    );
};
```

---

# 🔹 Why Component Typing Matters

Benefits:

✅ Safer props

✅ Better IntelliSense

✅ Easier debugging

---

# 🔹 Typing useState

---

## Example

```tsx
const [expenses, setExpenses] = useState<Expense[]>([]);
```

---

# 🔹 Why Important?

Ensures state contains only valid data.

---

# 🔹 Typing Functions

---

## Example

```ts
const addExpense = (expense: Expense): void => {
    console.log(expense);
};
```

---

# 🔹 Typing Async Functions

```ts
const fetchExpenses = async (): Promise<Expense[]> => {
    return [];
};
```

---

# 🌐 Typing API Responses

---

# 🔹 Example

```ts
type ExpenseResponse = {
    success: boolean;
    data: Expense[];
};
```

---

# 🔹 API Usage

```ts
const response: ExpenseResponse = await fetchExpenses();
```

---

# ⚙️ TypeScript Configuration

---

# 🔹 What is tsconfig.json?

Configuration file controlling TypeScript behavior.

---

# 🔹 Example Configuration

📁 `tsconfig.json`

```json
{
    "compilerOptions": {
        "target": "ESNext",
        "module": "ESNext",
        "strict": true,
        "jsx": "react-native",
        "baseUrl": "./",
        "paths": {
            "@/*": ["src/*"]
        }
    }
}
```

---

# 🔹 Important Options

| Option  | Purpose                  |
| ------- | ------------------------ |
| strict  | Strict type checking     |
| jsx     | React Native JSX support |
| baseUrl | Root path                |
| paths   | Import aliases           |

---

# 🔹 Why strict Mode Matters

```json
"strict": true
```

Benefits:

✅ Detects more errors

✅ Improves code quality

✅ Encourages safer coding

---

# 🔹 Path Aliases

Without aliases:

```ts
import ExpenseItem from "../../../components/expense-item";
```

With aliases:

```ts
import ExpenseItem from "@/components/expense-item";
```

Cleaner and easier to maintain.

---

# 🔹 Recommended Folder Structure

```text
src
│
├── app
│   └── index.tsx
│
├── components
│   └── expense-item.tsx
│
├── services
│   └── expenseService.ts
│
├── types
│   └── expense.ts
│
└── styles
    └── styles.ts
```

---

# ⚠️ Common Mistakes

❌ Overusing `any`
❌ Ignoring TypeScript errors
❌ Missing props typing
❌ Missing state typing
❌ Using incorrect unions
❌ Large untyped objects

---

# ✅ Best Practices

✅ Use strict mode
✅ Define reusable interfaces
✅ Avoid any whenever possible
✅ Use generics for reusable logic
✅ Keep types near usage
✅ Use consistent naming

---

# 🧪 Practice Exercises

1. Create Expense interface
2. Add Category union type
3. Type ExpenseItem props
4. Type API response structure
5. Create reusable generic utility
6. Add typed Context API
7. Move shared types into `/types` folder

---

# 📘 Chapter Summary

In this chapter, you:

✅ Learned why TypeScript is important
✅ Used basic TypeScript types
✅ Created interfaces and custom types
✅ Understood type vs interface
✅ Applied union types and generics
✅ Typed React Native components safely
✅ Typed hooks and async functions
✅ Configured TypeScript properly
✅ Improved ExpenseApp code safety and scalability
