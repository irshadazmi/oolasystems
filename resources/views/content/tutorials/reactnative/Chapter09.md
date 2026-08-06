# Chapter 9: Form Handling & Validation with Formik and Yup

---

In this chapter, we improve our ExpenseApp form handling by using two powerful libraries:

- **Formik** → Form state management
- **Yup** → Form validation

In previous chapters, we manually handled:

- Form state
- Validation
- Error handling

As applications grow, manual form handling becomes repetitive and difficult to maintain.

Formik and Yup help simplify:

- Input handling
- Validation
- Error messages
- Form submission

These libraries are widely used in real-world React Native applications.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand Formik basics
- Use Yup for validation
- Validate required fields
- Validate numeric inputs
- Display validation errors
- Handle form submission cleanly
- Build scalable forms

---

# 🔹 Why Formik?

Without Formik, forms usually require:

- Multiple `useState` hooks
- Manual validation logic
- Repetitive event handling

Formik centralizes all form-related logic and makes forms easier to manage.

---

## Without Formik

```tsx
const [description, setDescription] = useState("");
const [amount, setAmount] = useState("");
```

Managing many fields this way quickly becomes difficult in large applications.

---

## With Formik

```tsx
<Formik
  initialValues={{
    description: "",
    amount: "",
  }}
>
```

Formik automatically manages form state and provides helper methods for handling forms efficiently.

---

# 🔹 Why Yup?

Yup is a schema validation library used with Formik.

It provides a clean and readable way to define validation rules.

---

## Example

```tsx
description: Yup.string().required("Description is required");
```

---

# 📦 Install Required Libraries

```bash
npm install formik yup
```

---

# 🔹 Understanding Formik Flow

Formik handles:

1. Form state
2. Input changes
3. Validation
4. Form submission

This significantly reduces boilerplate code.

---

# 🔹 Basic Formik Example

```tsx
<Formik
  initialValues={{
    name: "",
  }}
  onSubmit={(values) => {
    console.log(values);
  }}
>
```

---

# 🔹 Validation Schema with Yup

Validation rules are defined using a schema object.

---

## Example

```tsx
const validationSchema = Yup.object({
  description: Yup.string().required("Description is required"),

  amount: Yup.number().required("Amount is required"),
});
```

---

# 🔹 Common Validation Rules

| Rule          | Purpose                    |
| ------------- | -------------------------- |
| `required()`  | Mandatory field            |
| `min()`       | Minimum length/value       |
| `max()`       | Maximum length/value       |
| `email()`     | Email validation           |
| `matches()`   | Regex validation           |
| `positive()`  | Positive number validation |
| `typeError()` | Custom type error          |

---

# 🧪 ExpenseApp Validation Requirements

For ExpenseApp:

| Field            | Validation                    |
| ---------------- | ----------------------------- |
| Category         | Required                      |
| Description      | Required                      |
| Amount           | Required + numeric + positive |
| Transaction Date | Required                      |

---

# 🔹 Creating Validation Schema

```tsx
import * as Yup from "yup";

const validationSchema = Yup.object({
  category: Yup.string().required("Category is required"),

  description: Yup.string().required("Description is required"),

  amount: Yup.number()
    .typeError("Amount must be a number")
    .required("Amount is required")
    .positive("Amount must be a positive number"),

  transactionDate: Yup.date().required("Transaction date is required"),
});
```

---

# 🔹 Displaying Validation Errors

Formik provides:

- `errors`
- `touched`

These are used to display validation messages.

---

## Example

```tsx
{
  errors.description && touched.description && (
    <Text style={styles.error}>{errors.description}</Text>
  );
}
```

---

# 🔹 Understanding `touched`

`touched` means:

👉 The user has interacted with the field.

This prevents validation errors from appearing immediately when the screen loads.

---

# 🔹 Understanding Formik Render Props

Formik’s `<Formik>` component uses a concept called the **render-prop pattern**.

Instead of passing normal JSX children, we pass a function as the child of `<Formik>`. Formik automatically calls this function and provides useful form-related properties and helper methods.

---

## Example

```tsx
<Formik
  initialValues={{ ... }}
  onSubmit={...}
>
  {({
    values,
    errors,
    touched,
    handleChange,
    handleBlur,
    handleSubmit,
    setFieldValue,
  }) => (
    <View>
      {/* Form UI */}
    </View>
  )}
</Formik>
```

---

# 🔹 What Formik Provides

Formik injects several useful properties into the function.

| Property          | Purpose                  |
| ----------------- | ------------------------ |
| `values`          | Current form values      |
| `errors`          | Validation errors        |
| `touched`         | Tracks interacted fields |
| `handleChange()`  | Updates field values     |
| `handleBlur()`    | Marks field as touched   |
| `handleSubmit()`  | Submits the form         |
| `setFieldValue()` | Manually updates a field |

---

# 🔹 Why It Looks Like an Anonymous Arrow Function

This syntax:

```tsx
({ values, errors, touched }) => <View>...</View>;
```

is simply an anonymous arrow function.

Formik passes an object containing form helpers, and we immediately destructure that object.

It is equivalent to:

```tsx
function renderFormikUI(formikProps) {
  const {
    values,
    errors,
    touched,
    handleChange,
    handleBlur,
    handleSubmit,
    setFieldValue,
  } = formikProps;

  return <View>...</View>;
}
```

---

# 🔹 Why Formik Uses This Pattern

This approach provides:

- Direct access to form state
- Cleaner form handling
- Flexible custom UI components
- Less repetitive code
- Better scalability for large forms

It also keeps the form logic and UI together in one place.

---

# 📦 Full ExpenseApp Example Using Formik & Yup

📁 `src/app/add.tsx`

```tsx
import { styles } from "@/src/styles/styles";
import DateTimePicker from "@react-native-community/datetimepicker";
import { Formik } from "formik";
import React from "react";
import {
  KeyboardAvoidingView,
  Platform,
  Pressable,
  Text,
  TextInput,
  View,
} from "react-native";
import * as Yup from "yup";

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

const validationSchema = Yup.object({
  category: Yup.string().required("Category is required"),

  description: Yup.string().required("Description is required"),

  amount: Yup.number()
    .typeError("Amount must be a number")
    .required("Amount is required")
    .positive("Amount must be a positive number"),

  transactionDate: Yup.date().required("Transaction date is required"),
});

export default function ExpenseAdd() {
  const [showDatePicker, setShowDatePicker] = React.useState(false);

  return (
    <KeyboardAvoidingView
      style={{ flex: 1 }}
      behavior={Platform.OS === "ios" ? "padding" : undefined}
    >
      <Formik
        initialValues={{
          category: "Food",
          description: "",
          amount: "",
          transactionDate: new Date(),
        }}
        validationSchema={validationSchema}
        onSubmit={(values) => {
          console.log(values);
        }}
      >
        {({
          values,
          errors,
          touched,
          handleChange,
          handleBlur,
          handleSubmit,
          setFieldValue,
        }) => (
          <View style={styles.container}>
            <Text style={styles.title}>Add Expense</Text>

            {/* Category */}
            <Text style={styles.label}>Category</Text>

            <View style={styles.chipContainer}>
              {categories.map((item) => (
                <Pressable
                  key={item}
                  style={[
                    styles.chip,
                    values.category === item && styles.activeChip,
                  ]}
                  onPress={() => setFieldValue("category", item)}
                >
                  <Text
                    style={[
                      styles.chipText,
                      values.category === item && styles.activeChipText,
                    ]}
                  >
                    {item}
                  </Text>
                </Pressable>
              ))}
            </View>

            {/* Description */}
            <Text style={styles.label}>Description</Text>

            <TextInput
              placeholder="Enter description"
              value={values.description}
              onChangeText={handleChange("description")}
              onBlur={handleBlur("description")}
              style={styles.textInput}
            />

            {errors.description && touched.description && (
              <Text style={styles.error}>{errors.description}</Text>
            )}

            {/* Amount */}
            <Text style={styles.label}>Amount (₹)</Text>

            <TextInput
              placeholder="Enter amount"
              keyboardType="numeric"
              value={values.amount}
              onChangeText={handleChange("amount")}
              onBlur={handleBlur("amount")}
              style={styles.textInput}
            />

            {errors.amount && touched.amount && (
              <Text style={styles.error}>{errors.amount}</Text>
            )}

            {/* Transaction Date */}
            <Text style={styles.label}>Transaction Date</Text>

            <Pressable
              style={styles.dateButton}
              onPress={() => setShowDatePicker(true)}
            >
              <Text style={styles.dateText}>
                {values.transactionDate.toLocaleDateString()}
              </Text>
            </Pressable>

            {showDatePicker && (
              <DateTimePicker
                value={values.transactionDate}
                mode="date"
                onChange={(event, selectedDate) => {
                  setShowDatePicker(false);

                  if (selectedDate) {
                    setFieldValue("transactionDate", selectedDate);
                  }
                }}
              />
            )}

            {/* Save Button */}
            <Pressable style={styles.button} onPress={() => handleSubmit()}>
              <Text style={styles.buttonText}>Save Expense</Text>
            </Pressable>
          </View>
        )}
      </Formik>
    </KeyboardAvoidingView>
  );
}
```

---

# 🎨 Update `styles/styles.ts`

Add the following error style:

```tsx
error: {
  color: "red",
  marginBottom: 10,
},
```

---

# 🔹 Benefits of Formik

Formik provides:

- Cleaner code
- Better scalability
- Easier validation
- Simplified form handling
- Better maintainability

---

# 🔹 Benefits of Yup

Yup provides:

- Centralized validation rules
- Cleaner validation logic
- Reusable schemas
- Better readability

---

# 🔹 Common Real-World Usage

Formik and Yup are commonly used for:

- Login forms
- Registration forms
- Payment forms
- Profile forms
- Expense tracking apps

---

# ✅ Best Practices

- Use Formik for complex forms
- Keep validation inside Yup schemas
- Show meaningful error messages
- Use `touched` before displaying errors
- Keep forms clean and readable

---

# ⚠️ Common Mistakes

- Using too many `useState` hooks for forms
- Forgetting to use `touched`
- Writing validation separately for every field
- Not validating numeric input properly
- Mixing validation logic inside UI code

---

# 🧪 Practice Exercises

1. Add email validation using Yup
2. Add minimum amount validation of ₹100
3. Add a Notes field with minimum character validation
4. Show validation error when category is not selected
5. Disable the Save button when the form is invalid

---

# 📘 Chapter Summary

In this chapter, you:

- Learned Formik basics
- Used Yup validation
- Created validation schemas
- Displayed validation errors
- Understood Formik render props
- Managed form state cleanly
- Built scalable form handling
