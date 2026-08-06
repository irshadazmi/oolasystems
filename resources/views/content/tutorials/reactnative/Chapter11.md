# Chapter 11: Navigation Params & Modals

---

In this chapter, we enhance the navigation flow of ExpenseApp by:

- Passing data between screens
- Reading route parameters
- Opening popup screens using modals

These concepts are commonly used in real-world applications.

For example:

- Opening expense details
- Editing an expense
- Opening forms in popup mode
- Passing selected item information between screens

We will extend the existing ExpenseApp screens created in previous chapters such as:

- `index.tsx`
- `add-expense.tsx`
- `categories.tsx`
- `settings.tsx`

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Pass data between screens
- Use route parameters with Expo Router
- Read params using `useLocalSearchParams`
- Handle optional parameters safely
- Implement modal screens
- Open and close modals
- Pass params to modal screens

---

# 🔄 Why Navigation Params?

Screens often need to share data.

For example:

```text
Expense List → Expense Details
```

When a user taps an expense item, we pass the selected expense information to another screen.

---

# 📦 Existing ExpenseApp Flow

We already created:

```text
(tabs)
├── index.tsx
├── add-expense.tsx

(drawer)
├── categories.tsx
├── settings.tsx
```

Now we will add:

```text
expense-details.tsx
add-expense-modal.tsx
```

---

# 📤 Passing Params Between Screens

Expo Router allows passing params using:

```tsx
router.push();
```

---

# Update `src/app/(tabs)/index.tsx`

We will now display a small expense list and navigate to details screen.

```tsx
import React from "react";

import { FlatList, Pressable, Text, View } from "react-native";

import { router } from "expo-router";

import { style } from "../../styles/styles";

const expenses = [
  {
    id: 1,
    description: "Food",
    amount: 250,
  },

  {
    id: 2,
    description: "Travel",
    amount: 1200,
  },

  {
    id: 3,
    description: "Shopping",
    amount: 800,
  },
];

export default function DashboardScreen() {
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Expense Dashboard</Text>

      <FlatList
        data={expenses}
        keyExtractor={(item) => item.id.toString()}
        renderItem={({ item }) => (
          <Pressable
            style={styles.card}
            onPress={() =>
              router.push({
                pathname: "/expense-details",

                params: {
                  id: item.id,
                  description: item.description,
                  amount: item.amount,
                },
              })
            }
          >
            <Text style={styles.description}>{item.description}</Text>

            <Text style={styles.amount}>₹{item.amount}</Text>
          </Pressable>
        )}
      />

      <Pressable
        style={styles.button}
        onPress={() => router.push("/add-expense-modal")}
      >
        <Text style={styles.buttonText}>Add Expense</Text>
      </Pressable>
    </View>
  );
}
```

---

# 🔹 Understanding `router.push()`

```tsx
router.push({
  pathname: "/expense-details",

  params: {
    id: item.id,
    description: item.description,
    amount: item.amount,
  },
});
```

👉 Navigates to another screen

👉 Passes data along with navigation

---

# 📥 Receiving Params

Create:

📁 `src/app/expense-details.tsx`

```tsx
import { Text, View } from "react-native";

import { useLocalSearchParams } from "expo-router";

import { style } from "../styles/styles";

export default function ExpenseDetailsScreen() {
  const { id, description, amount } = useLocalSearchParams();

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Expense Details</Text>

      <Text style={styles.detailsText}>Expense ID: {id}</Text>

      <Text style={styles.detailsText}>Description: {description}</Text>

      <Text style={styles.detailsText}>Amount: ₹{amount}</Text>
    </View>
  );
}
```

---

# 🔹 What is `useLocalSearchParams()`?

`useLocalSearchParams()` reads values passed during navigation.

---

# Example

```tsx
const { id, description, amount } = useLocalSearchParams();
```

👉 Similar to query parameters in web applications.

---

# ⚠️ Handling Optional Params Safely

Sometimes params may be missing.

---

# Safe Example

```tsx
const { description = "No Description", amount = 0 } = useLocalSearchParams();
```

---

# Why Important?

Prevents:

- Undefined errors
- Crashing UI
- Invalid rendering

---

# ✅ Best Practice: Pass Minimal Data

Instead of passing entire objects:

```tsx
params: {
  id: item.id;
}
```

Later, the screen can fetch complete data using API/database.

---

# Why Better?

- Smaller navigation payload
- Cleaner architecture
- Fresh data fetching
- Better scalability

---

# 🪟 Understanding Modals

A modal is a popup-like screen shown on top of the current screen.

---

# Common Use Cases

- Add Expense form
- Quick editing
- Confirm dialogs
- Filters
- Settings popup

---

# 📁 Create Modal Screen

Create:

📁 `src/app/add-expense-modal.tsx`

---

# Reusing Previous `add-expense.tsx`

Instead of creating a new form, we reuse the existing Add Expense screen created earlier.

```tsx
import AddExpense from "./(tabs)/add-expense";

export default function AddExpenseModal() {
  return <AddExpense />;
}
```

---

# Why Reuse Components?

Benefits:

- Avoids duplication
- Easier maintenance
- Consistent UI
- Better scalability

---

# ⚙️ Configure Modal in Root Layout

Update:

📁 `src/app/_layout.tsx`

```tsx
import { Stack } from "expo-router";

export default function RootLayout() {
  return (
    <Stack>
      <Stack.Screen
        name="(tabs)"
        options={{
          headerShown: false,
        }}
      />

      <Stack.Screen
        name="(drawer)"
        options={{
          headerShown: false,
        }}
      />

      <Stack.Screen
        name="expense-details"
        options={{
          title: "Expense Details",
        }}
      />

      <Stack.Screen
        name="add-expense-modal"
        options={{
          presentation: "modal",
          title: "Add Expense",
        }}
      />
    </Stack>
  );
}
```

---

# 🔹 What Does `presentation: "modal"` Mean?

```tsx
presentation: "modal";
```

👉 Displays screen as popup modal.

---

# Modal Behavior

| Platform | Behavior           |
| -------- | ------------------ |
| iOS      | Slides from bottom |
| Android  | Opens as overlay   |

---

# 🚀 Opening Modal

We already added:

```tsx
router.push("/add-expense-modal");
```

inside dashboard screen.

---

# 🔙 Closing Modal

Expo Router provides:

```tsx
router.back();
```

---

# Example

Inside `add-expense.tsx`:

```tsx
import { router } from "expo-router";

router.back();
```

👉 Closes modal and returns to previous screen.

---

# 📤 Passing Params to Modal

Modals can also receive params.

---

# Example

```tsx
router.push({
  pathname: "/add-expense-modal",

  params: {
    id: 1,
  },
});
```

---

# 📥 Reading Params in Modal

```tsx
const { id } = useLocalSearchParams();
```

---

# 🧪 ExpenseApp Navigation Flow

---

# Primary Navigation (Tabs)

```text
Dashboard
Add Expense
```

---

# Secondary Navigation (Drawer)

```text
Categories
Settings
```

---

# Additional Screens

```text
Expense Details
Add Expense Modal
```

---

# Full Flow

```text
Dashboard
   ↓
Expense Details
   ↓
Edit/Add Expense Modal
```

---

# 🎨 Update `styles/styles.ts`

Add:

```tsx
card: {
  backgroundColor: "#fff",
  padding: 15,
  borderRadius: 10,
  marginBottom: 10,
  elevation: 2,
},

detailsText: {
  fontSize: 18,
  marginBottom: 10,
},
```

---

# ⚠️ Common Mistakes

---

# ❌ Passing Large Objects

```tsx
params: {
  expense: item;
}
```

---

# ✅ Better

```tsx
params: {
  id: item.id;
}
```

---

# ❌ Creating Separate Duplicate Forms

Avoid copying entire Add Expense screen into modal.

---

# ✅ Better

Reuse existing component.

---

# ❌ Using Modals for Complex Navigation

Modals should remain lightweight.

---

# ✅ Best Practices

- Pass minimal params
- Validate params safely
- Reuse existing components
- Keep modals lightweight
- Use modals for short interactions
- Keep navigation structure predictable

---

# 📘 Chapter Summary

In this chapter, you:

- Passed params between screens
- Used `useLocalSearchParams`
- Implemented Expense Details screen
- Created modal screens
- Reused existing Add Expense form
- Opened and closed modals
- Passed params to modal screens
- Improved ExpenseApp navigation flow
