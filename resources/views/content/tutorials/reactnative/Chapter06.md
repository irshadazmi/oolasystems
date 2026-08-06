# Chapter 6: Inputs & Form Handling

---

In this chapter, we extend the **ExpenseApp transaction form** created earlier and learn how to build better and more interactive forms in React Native.

Forms are one of the most important parts of any application. Users interact with forms to:

- Add expenses
- Register accounts
- Log in
- Update settings
- Search and filter data

React Native provides several components to handle forms efficiently, such as:

- `TextInput`
- `Pressable`
- `KeyboardAvoidingView`

In this chapter, we will improve the transaction form by adding:

- Proper labels
- Category chips
- Transaction date picker
- Validation
- Keyboard handling
- Better styling

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Use `TextInput` effectively
- Build controlled components
- Handle form state using `useState`
- Create category chips
- Use native Date Picker
- Validate user input
- Improve keyboard handling
- Build better mobile forms

---

# ✍️ Understanding TextInput

`TextInput` is used to capture user input.

It is one of the most commonly used React Native components.

---

## Basic Example

```tsx
<TextInput placeholder="Enter amount" />
```

---

## ExpenseApp Example

```tsx
<TextInput
    placeholder="Enter description"
    value={description}
    onChangeText={setDescription}
    style={styles.input}
/>
```

---

## 🔹 Important Props

| Prop           | Purpose               |
| -------------- | --------------------- |
| `value`        | Current value         |
| `onChangeText` | Updates state         |
| `placeholder`  | Displays hint         |
| `keyboardType` | Opens proper keyboard |
| `style`        | Applies styling       |

---

# 🔄 Controlled Components

In React Native, form fields are usually controlled by state.

---

## Example

```tsx
const [description, setDescription] = useState("");
```

```tsx
<TextInput value={description} onChangeText={setDescription} />
```

---

## Why Controlled Components?

Controlled components:

- Keep UI synchronized with state
- Simplify validation
- Improve predictability
- Make debugging easier

---

# 🏷️ Adding Labels

Labels improve readability and user experience.

---

## ❌ Without Labels

```tsx
<TextInput placeholder="Amount" />
```

---

## ✅ With Labels

```tsx
<Text style={styles.label}>
  Amount (₹)
</Text>

<TextInput
  placeholder="Enter amount"
  style={styles.input}
/>
```

---

## Why Labels Matter

Labels:

- Make forms easier to understand
- Improve accessibility
- Create professional-looking UI

---

# 🎯 Category Chips

Instead of dropdowns, mobile apps often use chips for small option lists.

---

## Why Chips?

Chips provide:

- Faster selection
- Better mobile UX
- Cleaner interface
- Modern design pattern

---

## Example

```tsx
<View style={styles.chipContainer}>
    {categories.map((item) => (
        <Pressable
            key={item}
            style={[styles.chip, category === item && styles.activeChip]}
            onPress={() => setCategory(item)}
        >
            <Text
                style={[
                    styles.chipText,
                    category === item && styles.activeChipText,
                ]}
            >
                {item}
            </Text>
        </Pressable>
    ))}
</View>
```

---

# 🎨 Updating `styles/styles.ts`

Add the following styles:

```tsx
chipContainer: {
  flexDirection: "row",
  flexWrap: "wrap",
  marginBottom: 15,
},
chip: {
  backgroundColor: "#e5e5e5",
  paddingVertical: 8,
  paddingHorizontal: 15,
  borderRadius: 20,
  marginRight: 10,
  marginBottom: 10,
},
activeChip: {
  backgroundColor: "#007bff",
},
chipText: {
  color: "#333",
},
activeChipText: {
  color: "#fff",
},
```

---

# 📅 Transaction Date Picker

Financial applications usually require transaction dates.

Instead of entering dates manually, mobile apps commonly use a native Date Picker.

---

# Install DateTime Picker

```bash
npx expo install @react-native-community/datetimepicker
```

---

# Why Date Picker?

Date Picker:

- Prevents invalid dates
- Improves mobile UX
- Provides native platform experience
- Simplifies date handling

---

# Example

```tsx
<Pressable style={styles.dateButton} onPress={() => setShowDatePicker(true)}>
    <Text style={styles.dateText}>{transactionDate.toLocaleDateString()}</Text>
</Pressable>
```

---

# Showing Date Picker

```tsx
{
    showDatePicker && (
        <DateTimePicker
            value={transactionDate}
            mode="date"
            onChange={(event, selectedDate) => {
                setShowDatePicker(false);

                if (selectedDate) {
                    setTransactionDate(selectedDate);
                }
            }}
        />
    );
}
```

---

# Update `styles/styles.ts`

Add:

```tsx
dateButton: {
  borderWidth: 1,
  borderColor: "#ccc",
  borderRadius: 8,
  padding: 15,
  marginBottom: 15,
  backgroundColor: "#fff",
},
dateText: {
  fontSize: 16,
},
```

---

# ✅ Validation

Validation ensures users enter correct data.

---

## Required Field Validation

```tsx
if (!description || !amount) {
    alert("Please fill all fields");
    return;
}
```

---

## Numeric Validation

```tsx
if (isNaN(Number(amount))) {
    alert("Amount must be numeric");
    return;
}
```

---

# ⌨️ Keyboard Handling

Mobile keyboards can hide form fields.

React Native provides `KeyboardAvoidingView` to improve user experience.

---

## Example

```tsx
<KeyboardAvoidingView
  style={{ flex: 1 }}
  behavior={
    Platform.OS === "ios"
      ? "padding"
      : undefined
  }
>
```

---

## Why Important?

- Keeps inputs visible
- Prevents keyboard overlap
- Improves mobile usability

---

# 📦 Full Enhanced Expense Form

📁 `src/app/add-expense.tsx`

```tsx
import React, { useState } from "react";
import {
    KeyboardAvoidingView,
    Platform,
    Pressable,
    Text,
    TextInput,
    View,
} from "react-native";

import DateTimePicker from "@react-native-community/datetimepicker";

import { styles as style } from "@/src/styles/styles";

const categories = [
    "Food",
    "Travel",
    "Shopping",
    "Bills",
    "Entertainment",
    "Electronics",
    "Health",
    "Education",
    "Other",
];

export default function ExpenseAdd() {
    const [description, setDescription] = useState("");

    const [amount, setAmount] = useState("");

    const [category, setCategory] = useState("Food");

    const [transactionDate, setTransactionDate] = useState(new Date());

    const [showDatePicker, setShowDatePicker] = useState(false);

    const handleSave = () => {
        if (!description || !amount) {
            alert("Please fill all fields");

            return;
        }

        if (isNaN(Number(amount))) {
            alert("Amount must be numeric");

            return;
        }

        console.log({
            description,
            amount,
            category,
            transactionDate,
        });
    };

    return (
        <KeyboardAvoidingView
            style={{ flex: 1 }}
            behavior={Platform.OS === "ios" ? "padding" : undefined}
        >
            <View style={style.container}>
                <Text style={style.title}>Add Expense</Text>

                {/* Category */}

                <Text style={style.label}>Category</Text>

                <View style={style.chipContainer}>
                    {categories.map((item) => (
                        <Pressable
                            key={item}
                            style={[
                                style.chip,

                                category === item && style.activeChip,
                            ]}
                            onPress={() => setCategory(item)}
                        >
                            <Text
                                style={[
                                    style.chipText,

                                    category === item && style.activeChipText,
                                ]}
                            >
                                {item}
                            </Text>
                        </Pressable>
                    ))}
                </View>

                {/* Description */}

                <Text style={style.label}>Description</Text>

                <TextInput
                    placeholder="Enter description"
                    value={description}
                    onChangeText={setDescription}
                    style={style.textInput}
                />

                {/* Amount */}

                <Text style={style.label}>Amount (₹)</Text>

                <TextInput
                    placeholder="Enter amount"
                    keyboardType="numeric"
                    value={amount}
                    onChangeText={setAmount}
                    style={style.textInput}
                />

                {/* Transaction Date */}

                <Text style={style.label}>Transaction Date</Text>

                <Pressable
                    style={style.dateButton}
                    onPress={() => setShowDatePicker(true)}
                >
                    <Text style={style.dateText}>
                        {transactionDate.toLocaleDateString()}
                    </Text>
                </Pressable>

                {showDatePicker && (
                    <DateTimePicker
                        value={transactionDate}
                        mode="date"
                        onChange={(event, selectedDate) => {
                            setShowDatePicker(false);

                            if (selectedDate) {
                                setTransactionDate(selectedDate);
                            }
                        }}
                    />
                )}

                {/* Save Button */}

                <Pressable style={style.button} onPress={handleSave}>
                    <Text style={style.buttonText}>Save Expense</Text>
                </Pressable>
            </View>
        </KeyboardAvoidingView>
    );
}
```

---

# ✅ Best Practices

- Use controlled inputs
- Add proper labels
- Validate user input
- Use appropriate keyboard types
- Keep forms simple and clean
- Use reusable styles

---

# ⚠️ Common Mistakes

- Forgetting to validate empty input fields
- Using uncontrolled `TextInput` components
- Not converting numeric input from string to number
- Allowing the keyboard to hide important form fields

---

# 🧪 Practice Exercises

1. Add a new “Notes” field to the expense form
2. Add validation for minimum expense amount
3. Create additional category chips such as “Medical” and “Education”
4. Display selected transaction date below the form

---

# 📘 Chapter Summary

In this chapter, you:

- Built interactive forms
- Used `TextInput` effectively
- Implemented controlled components
- Created category chips
- Used native Date Picker
- Added validation
- Improved keyboard handling
- Enhanced form styling
