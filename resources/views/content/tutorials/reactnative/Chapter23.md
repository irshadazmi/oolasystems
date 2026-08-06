# Chapter 23: Advanced TypeScript – Navigation Types & API Typings

---

In previous chapters, we learned:

- TypeScript fundamentals
- React Native component typing
- Context API typing
- Async function typing
- API response typing

As React Native applications grow larger, managing types becomes more important.

Large applications may contain:

- Multiple screens
- Complex navigation
- API integrations
- Shared models
- Reusable components

Without proper typing:

❌ Navigation errors occur

❌ Invalid API data causes crashes

❌ Screen parameters become unsafe

❌ Debugging becomes difficult

To solve these problems, modern React Native applications use:

✅ Strong navigation typing

✅ Shared reusable models

✅ Typed API responses

✅ Utility types

✅ Nullable safety patterns

In this chapter, we will apply advanced TypeScript patterns to ExpenseApp.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Type navigation routes safely
- Type screen props correctly
- Type route parameters
- Create reusable API response types
- Use utility types
- Handle nullable values safely
- Build reusable TypeScript models
- Improve ExpenseApp scalability

---

# ⚡ Why Advanced Typing Matters

As applications grow:

- Screens increase
- APIs increase
- Components become reusable
- State becomes complex

Advanced typing helps maintain:

✅ Safety

✅ Maintainability

✅ Scalability

✅ Better developer experience

---

# 🔹 Real ExpenseApp Problems

Without advanced typing:

❌ Wrong route names

❌ Missing navigation parameters

❌ Invalid API structures

❌ Undefined values causing crashes

---

# 🔹 Goal of Advanced Typing

We want:

✅ Safe navigation

✅ Predictable APIs

✅ Reusable models

✅ Safer UI rendering

---

# 🧭 Typing Navigation Routes

Navigation typing ensures safe screen navigation.

---

# 🔹 What is Route Typing?

Route typing defines:

✅ Available screens

✅ Expected parameters

✅ Parameter types

---

# 🔹 Create RootStackParamList

📁 `src/types/navigation.ts`

```ts id="nav001"
export type RootStackParamList = {
    Home: undefined;

    AddExpense: undefined;

    ExpenseDetails: {
        id: number;
    };

    EditExpense: {
        id: number;
    };
};
```

---

# 🔹 Understanding Route Types

| Route          | Parameters       |
| -------------- | ---------------- |
| Home           | None             |
| AddExpense     | None             |
| ExpenseDetails | `{ id: number }` |

---

# 🔹 Why Important?

Without route typing:

❌ Wrong params allowed

❌ Invalid navigation calls

With route typing:

✅ Safer navigation

✅ Better IntelliSense

✅ Better debugging

---

# 🔹 Typing Navigation Props

📁 `src/app/index.tsx`

```ts id="nav002"
import { StackNavigationProp } from "@react-navigation/stack";

import { RootStackParamList } from "../types/navigation";

type HomeNavigationProp = StackNavigationProp<RootStackParamList, "Home">;
```

---

# 🔹 Use Navigation Type

```tsx id="nav003"
type Props = {
    navigation: HomeNavigationProp;
};

export default function HomeScreen({ navigation }: Props) {
    return (
        <Pressable
            onPress={() =>
                navigation.navigate("ExpenseDetails", {
                    id: 1,
                })
            }
        >
            <Text>Open Details</Text>
        </Pressable>
    );
}
```

---

# 🔹 What TypeScript Protects

TypeScript now validates:

✅ Route names

✅ Required parameters

✅ Parameter types

---

# ❌ Invalid Example

```tsx id="nav004"
navigation.navigate("ExpenseDetails", {
    id: "wrong",
});
```

TypeScript immediately shows an error.

---

# 🛣️ Typing Route Params

Route params should also be typed safely.

---

# 🔹 RouteProp

```ts id="nav005"
import { RouteProp } from "@react-navigation/native";
```

---

# 🔹 Create Route Type

```ts id="nav006"
type ExpenseDetailsRouteProp = RouteProp<RootStackParamList, "ExpenseDetails">;
```

---

# 🔹 Use Route Params

```tsx id="nav007"
type Props = {
    route: ExpenseDetailsRouteProp;
};

export default function ExpenseDetails({ route }: Props) {
    const { id } = route.params;

    return <Text>Expense ID: {id}</Text>;
}
```

---

# 🔹 Why Important?

Benefits:

✅ Safer param access

✅ Better IntelliSense

✅ Prevents undefined access

---

# 🔹 Combining Navigation & Route Types

Most screens need both.

---

# 🔹 Example

```ts id="nav008"
type Props = {
    navigation: StackNavigationProp<RootStackParamList, "ExpenseDetails">;

    route: RouteProp<RootStackParamList, "ExpenseDetails">;
};
```

---

# 🌐 Typing API Responses

APIs should always be typed.

---

# 🔹 Create Expense Model

📁 `src/types/expense.ts`

```ts id="api001"
export interface Expense {
    id: number;

    title: string;

    amount: number;

    category: string;

    createdAt: string;
}
```

---

# 🔹 Why Shared Models?

Benefits:

✅ Reusable types

✅ Consistent structure

✅ Easier maintenance

---

# 🔹 Typing API Response

```ts id="api002"
type ExpenseResponse = {
    success: boolean;

    data: Expense[];
};
```

---

# 🔹 Async API Function

📁 `src/services/expense-service.ts`

```ts id="api003"
const fetchExpenses = async (): Promise<Expense[]> => {
    return [
        {
            id: 1,
            title: "Food",
            amount: 250,
            category: "Food",
            createdAt: "2026-01-10",
        },
    ];
};
```

---

# 🔹 Why Promise Typing Matters

Benefits:

✅ Predictable async responses

✅ Better error handling

✅ Safer state updates

---

# 🔹 Typing useState

```tsx id="api004"
const [expenses, setExpenses] = useState<Expense[]>([]);
```

---

# 🔹 Nullable API State

During loading, data may not exist yet.

---

# 🔹 Example

```tsx id="api005"
const [selectedExpense, setSelectedExpense] = useState<Expense | null>(null);
```

---

# 🔹 Why Nullable Types Matter

Without null safety:

❌ Application crashes

With null safety:

✅ Safer rendering

✅ Better async handling

---

# 🧩 Utility Types

TypeScript provides powerful utility types.

These help build flexible applications.

---

# 🔹 Partial<T>

Makes all properties optional.

---

# 🔹 Example

```ts id="util001"
type ExpenseUpdate = Partial<Expense>;
```

---

# 🔹 ExpenseApp Use Case

Used for:

✅ Edit forms

✅ Partial updates

✅ Optional API payloads

---

# 🔹 Example

```ts id="util002"
const updateExpense = (data: Partial<Expense>) => {
    console.log(data);
};
```

---

# 🔹 Pick<T, K>

Selects specific fields.

---

# 🔹 Example

```ts id="util003"
type ExpenseSummary = Pick<Expense, "title" | "amount">;
```

---

# 🔹 Why Useful?

Useful for:

✅ Lightweight UI models

✅ Dashboard summaries

✅ List rendering

---

# 🔹 Omit<T, K>

Removes specific fields.

---

# 🔹 Example

```ts id="util004"
type NewExpense = Omit<Expense, "id">;
```

---

# 🔹 ExpenseApp Use Case

Useful when:

✅ Creating new expense

because server usually generates IDs.

---

# 🔹 Readonly<T>

Prevents modification.

---

# 🔹 Example

```ts id="util005"
type ReadonlyExpense = Readonly<Expense>;
```

---

# 🔹 Why Useful?

Protects immutable data.

---

# 🛡️ Handling Optional Values Safely

Real-world APIs often return incomplete data.

---

# 🔹 Optional Properties

```ts id="safe001"
type Expense = {
    id: number;

    title: string;

    amount?: number;
};
```

---

# 🔹 Optional Chaining

```tsx id="safe002"
console.log(expense?.title);
```

---

# 🔹 Why Important?

Prevents:

❌ Cannot read property of undefined

errors.

---

# 🔹 Nullish Coalescing

```tsx id="safe003"
const amount = expense.amount ?? 0;
```

---

# 🔹 Difference from ||

`??` only falls back for:

- null
- undefined

This is safer than `||`.

---

# 🔹 ExpenseApp Example

```tsx id="safe004"
<Text>₹{expense.amount ?? 0}</Text>
```

---

# 🧪 Full ExpenseApp Example

📁 `src/app/expense-details.tsx`

```tsx id="full001"
import React, { useEffect, useState } from "react";

import { Text, View } from "react-native";

import { RouteProp } from "@react-navigation/native";

import { RootStackParamList } from "../types/navigation";

import { Expense } from "../types/expense";

type Props = {
    route: RouteProp<RootStackParamList, "ExpenseDetails">;
};

export default function ExpenseDetails({ route }: Props) {
    const { id } = route.params;

    const [expense, setExpense] = useState<Expense | null>(null);

    useEffect(() => {
        setExpense({
            id,
            title: "Food",
            amount: 200,
            category: "Food",
            createdAt: "2026-01-10",
        });
    }, [id]);

    return (
        <View>
            <Text>{expense?.title}</Text>

            <Text>₹{expense?.amount}</Text>
        </View>
    );
}
```

---

# 🔹 Recommended Folder Structure

```text id="folder001"
src
│
├── app
│   └── expense-details.tsx
│
├── services
│   └── expense-service.ts
│
├── types
│   ├── expense.ts
│   └── navigation.ts
│
└── components
    └── expense-item.tsx
```

---

# ⚡ Performance & Scalability Benefits

Strong typing improves:

✅ Refactoring safety
✅ Team collaboration
✅ Code readability
✅ Long-term maintainability

---

# ⚠️ Common Mistakes

❌ Using `any`
❌ Not typing navigation params
❌ Ignoring nullable values
❌ Duplicating type definitions
❌ Mixing API types with UI types

---

# ✅ Best Practices

✅ Create shared `/types` folder
✅ Type all navigation routes
✅ Use utility types wisely
✅ Handle null safely
✅ Keep types reusable
✅ Use interfaces for models

---

# 🧪 Practice Exercises

1. Add EditExpense route typing
2. Create reusable API response type
3. Add nullable loading states
4. Create ExpenseSummary type using Pick
5. Create NewExpense type using Omit
6. Add readonly properties
7. Create typed Context API state

---

# 📘 Chapter Summary

In this chapter, you:

✅ Typed navigation routes safely
✅ Typed screen props correctly
✅ Typed route parameters
✅ Created reusable API models
✅ Used utility types
✅ Handled nullable values safely
✅ Improved ExpenseApp scalability
✅ Applied advanced TypeScript patterns
