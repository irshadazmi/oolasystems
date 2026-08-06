# Chapter 24: Expo Router Authentication & Transaction Module

---

In previous chapters, we learned:

- Navigation
- Context API
- TypeScript
- Forms & Validation
- Theme Context
- AsyncStorage
- API Integration

Now let us build a more realistic module structure using:

✅ Expo Router Folder Routing

We will organize our application using:

```text id="folder001"
app/
├── (auth)/
└── (transaction)/
```

This chapter focuses on:

✅ Authentication Screens

- Login
- Register
- Logout
- Forgot Password

✅ Transaction Screens

- List Transactions
- Add Transaction
- Edit Transaction

using simple and scalable Expo Router folder-based navigation.

The examples in this chapter are simplified and optimized versions of your production-ready implementation.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand Expo Router folder routing
- Organize screens using route groups
- Build authentication pages
- Build transaction CRUD screens
- Use dynamic routes
- Use reusable forms
- Navigate between screens
- Simplify React Native architecture

---

# ⚡ What is Expo Router?

Expo Router uses the file system for navigation.

Instead of manually defining routes:

```tsx id="oldnav001"
<Stack.Screen />
```

screens are automatically generated from folders and files.

---

# 🔹 Why Expo Router?

Benefits:

✅ Cleaner architecture

✅ Easier navigation

✅ Better scalability

✅ Faster development

---

# 🔹 Route Groups

Folders inside parentheses create route groups.

Example:

```text id="folder002"
(auth)
(transaction)
```

These help organize screens logically.

---

# 🔹 Important Point

Route groups:

✅ Organize files

❌ Do NOT appear in URLs

---

# 🧩 Application Structure

---

# 🔹 Folder Structure

```text id="folder003"
src
│
├── app
│   ├── (auth)
│   │   ├── login.tsx
│   │   ├── register.tsx
│   │   ├── forgot-password.tsx
│   │   └── logout.tsx
│   │
│   ├── (transaction)
│   │   ├── index.tsx
│   │   ├── add.tsx
│   │   └── [id].tsx
│
├── components
│   └── transaction-form.tsx
│
└── styles
    └── styles.ts
```

---

# 🔐 Authentication Module

The authentication module handles:

✅ Login

✅ Registration

✅ Password recovery

✅ Logout

---

# 🔹 Login Screen

📁 `src/app/(auth)/login.tsx`

Simplified version:

```tsx id="login001"
import React from "react";

import { View, Text, TextInput, Pressable } from "react-native";

import { Link, useRouter } from "expo-router";

import { Formik } from "formik";

import * as Yup from "yup";

import { useStyles } from "@/styles/styles";

const LoginSchema = Yup.object({
    email: Yup.string().email().required(),

    password: Yup.string().required(),
});

export default function Login() {
    const styles = useStyles();

    const router = useRouter();

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Login</Text>

            <Formik
                initialValues={{
                    email: "",
                    password: "",
                }}
                validationSchema={LoginSchema}
                onSubmit={() => {
                    router.replace("/(transaction)");
                }}
            >
                {({ values, handleChange, handleSubmit }) => (
                    <View>
                        <TextInput
                            style={styles.input}
                            placeholder="Email"
                            value={values.email}
                            onChangeText={handleChange("email")}
                        />

                        <TextInput
                            style={styles.input}
                            placeholder="Password"
                            secureTextEntry
                            value={values.password}
                            onChangeText={handleChange("password")}
                        />

                        <Pressable
                            style={styles.button}
                            onPress={() => handleSubmit()}
                        >
                            <Text style={styles.buttonText}>Login</Text>
                        </Pressable>

                        <Link href="/(auth)/register">Register</Link>

                        <Link href="/(auth)/forgot-password">
                            Forgot Password
                        </Link>
                    </View>
                )}
            </Formik>
        </View>
    );
}
```

---

# 🔹 What We Simplified

Compared to production code:

✅ Removed complex API logic

✅ Removed loaders

✅ Reduced inline styles

✅ Simplified navigation

This helps beginners focus on routing and forms first.

---

# 📝 Register Screen

📁 `src/app/(auth)/register.tsx`

```tsx id="register001"
import React from "react";

import { View, Text, TextInput, Pressable } from "react-native";

import { Link, useRouter } from "expo-router";

import { Formik } from "formik";

import { useStyles } from "@/styles/styles";

export default function Register() {
    const styles = useStyles();

    const router = useRouter();

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Register</Text>

            <Formik
                initialValues={{
                    fullName: "",
                    email: "",
                    password: "",
                }}
                onSubmit={() => {
                    router.replace("/(transaction)");
                }}
            >
                {({ values, handleChange, handleSubmit }) => (
                    <View>
                        <TextInput
                            style={styles.input}
                            placeholder="Full Name"
                            value={values.fullName}
                            onChangeText={handleChange("fullName")}
                        />

                        <TextInput
                            style={styles.input}
                            placeholder="Email"
                            value={values.email}
                            onChangeText={handleChange("email")}
                        />

                        <TextInput
                            style={styles.input}
                            placeholder="Password"
                            secureTextEntry
                            value={values.password}
                            onChangeText={handleChange("password")}
                        />

                        <Pressable
                            style={styles.button}
                            onPress={() => handleSubmit()}
                        >
                            <Text style={styles.buttonText}>Register</Text>
                        </Pressable>

                        <Link href="/(auth)/login">
                            Already have an account?
                        </Link>
                    </View>
                )}
            </Formik>
        </View>
    );
}
```

---

# 🔑 Forgot Password Screen

📁 `src/app/(auth)/forgot-password.tsx`

```tsx id="forgot001"
import React from "react";

import { View, Text, TextInput, Pressable, Alert } from "react-native";

import { useStyles } from "@/styles/styles";

export default function ForgotPassword() {
    const styles = useStyles();

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Forgot Password</Text>

            <TextInput style={styles.input} placeholder="Enter Email" />

            <Pressable
                style={styles.button}
                onPress={() => Alert.alert("Reset link sent")}
            >
                <Text style={styles.buttonText}>Send Reset Link</Text>
            </Pressable>
        </View>
    );
}
```

---

# 🚪 Logout Screen

📁 `src/app/(auth)/logout.tsx`

```tsx id="logout001"
import { useEffect } from "react";

import { useRouter } from "expo-router";

export default function Logout() {
    const router = useRouter();

    useEffect(() => {
        router.replace("/(auth)/login");
    }, []);

    return null;
}
```

---

# 💳 Transaction Module

Transaction module handles:

✅ List transactions

✅ Add transaction

✅ Edit transaction

---

# 📄 Transaction List Screen

📁 `src/app/(transaction)/index.tsx`

Simplified version:

```tsx id="trx001"
import React, { useState } from "react";

import { View, Text, FlatList, Pressable } from "react-native";

import { useRouter } from "expo-router";

import { useStyles } from "@/styles/styles";

const DATA = [
    {
        id: 1,
        description: "Food",
        amount: 250,
    },
    {
        id: 2,
        description: "Travel",
        amount: 500,
    },
];

export default function Transactions() {
    const styles = useStyles();

    const router = useRouter();

    return (
        <View style={styles.container}>
            <View style={styles.row}>
                <Text style={styles.title}>Transactions</Text>

                <Pressable onPress={() => router.push("/(transaction)/add")}>
                    <Text>+ Add</Text>
                </Pressable>
            </View>

            <FlatList
                data={DATA}
                keyExtractor={(item) => item.id.toString()}
                renderItem={({ item }) => (
                    <Pressable
                        style={styles.card}
                        onPress={() => router.push(`/(transaction)/${item.id}`)}
                    >
                        <Text>{item.description}</Text>

                        <Text>₹{item.amount}</Text>
                    </Pressable>
                )}
            />
        </View>
    );
}
```

---

# ➕ Add Transaction Screen

📁 `src/app/(transaction)/add.tsx`

```tsx id="trx002"
import React from "react";

import { View, Text } from "react-native";

import TransactionForm from "@/components/transaction-form";

import { useStyles } from "@/styles/styles";

export default function AddTransaction() {
    const styles = useStyles();

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Add Transaction</Text>

            <TransactionForm />
        </View>
    );
}
```

---

# ✏️ Edit Transaction Screen

Expo Router supports dynamic routes using:

```text id="folder004"
[id].tsx
```

---

# 🔹 Why Dynamic Routes?

This allows:

```text id="folder005"
/(transaction)/1
(transaction)/2
(transaction)/3
```

---

# 📁 `src/app/(transaction)/[id].tsx`

```tsx id="trx003"
import React from "react";

import { View, Text } from "react-native";

import { useLocalSearchParams } from "expo-router";

import TransactionForm from "@/components/transaction-form";

import { useStyles } from "@/styles/styles";

export default function EditTransaction() {
    const styles = useStyles();

    const { id } = useLocalSearchParams();

    return (
        <View style={styles.container}>
            <Text style={styles.title}>Edit Transaction</Text>

            <TransactionForm id={Number(id)} />
        </View>
    );
}
```

---

# 🧩 Reusable Transaction Form

Instead of creating:

❌ Separate Add Form

❌ Separate Edit Form

we use:

✅ One reusable form component

---

# 🔹 Why Reusable Forms?

Benefits:

✅ Less code duplication

✅ Easier maintenance

✅ Cleaner architecture

---

# 📁 `src/components/transaction-form.tsx`

Simplified version:

```tsx id="trx004"
import React from "react";

import { View, TextInput, Pressable, Text } from "react-native";

import { Formik } from "formik";

import { useStyles } from "@/styles/styles";

type Props = {
    id?: number;
};

export default function TransactionForm({ id }: Props) {
    const styles = useStyles();

    return (
        <Formik
            initialValues={{
                description: "",
                amount: "",
            }}
            onSubmit={(values) => {
                console.log(values);
            }}
        >
            {({ values, handleChange, handleSubmit }) => (
                <View>
                    <TextInput
                        style={styles.input}
                        placeholder="Description"
                        value={values.description}
                        onChangeText={handleChange("description")}
                    />

                    <TextInput
                        style={styles.input}
                        placeholder="Amount"
                        keyboardType="numeric"
                        value={values.amount}
                        onChangeText={handleChange("amount")}
                    />

                    <Pressable
                        style={styles.button}
                        onPress={() => handleSubmit()}
                    >
                        <Text style={styles.buttonText}>
                            {id ? "Update" : "Save"}
                        </Text>
                    </Pressable>
                </View>
            )}
        </Formik>
    );
}
```

---

# 🎨 Update styles.ts

📁 `src/styles/styles.ts`

Add minimal reusable styles:

```tsx id="style001"
input: {
    borderWidth: 1,
    borderColor: "#ccc",
    borderRadius: 8,
    padding: 12,
    marginBottom: 12,
},

link: {
    marginTop: 12,
    color: "#007bff",
},

errorText: {
    color: "red",
    marginBottom: 10,
},
```

---

# 🔹 Navigation Flow

```text id="flow001"
Login
   ↓
Transactions List
   ↓
Add Transaction
   ↓
Edit Transaction
```

---

# 🔹 Why This Architecture Works Well

Benefits:

✅ Feature-based folders

✅ Cleaner navigation

✅ Easier scalability

✅ Better maintainability

✅ Reusable components

---

# ⚡ Performance Considerations

✅ Reuse form components

✅ Keep screens small

✅ Use FlatList for lists

✅ Avoid duplicated state

---

# ⚠️ Common Mistakes

❌ Large monolithic screens

❌ Duplicated forms

❌ Inline complex styles

❌ Deep nested navigation

❌ Hardcoded navigation paths

---

# ✅ Best Practices

✅ Organize by feature folders
✅ Use reusable forms
✅ Keep routes predictable
✅ Use dynamic routing wisely
✅ Centralize styles
✅ Keep screens simple

---

# 🧪 Practice Exercises

1. Add transaction delete screen
2. Add transaction search
3. Add transaction validation
4. Add logout confirmation
5. Add protected routes
6. Add transaction categories
7. Add transaction details screen

---

# 📘 Chapter Summary

In this chapter, you:

✅ Learned Expo Router folder routing
✅ Built authentication screens
✅ Built transaction CRUD screens
✅ Used dynamic routes
✅ Created reusable forms
✅ Simplified React Native architecture
✅ Organized screens using route groups
✅ Improved ExpenseApp scalability
