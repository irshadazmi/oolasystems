# Chapter 10: Navigation with Expo Router

---

In this chapter, we implement navigation using **Expo Router**, which provides a modern file-based routing system for React Native applications.

Navigation is one of the most important parts of any mobile app. In ExpenseApp, navigation allows users to move between screens such as:

- Dashboard
- Expenses
- Categories
- Settings

Expo Router simplifies navigation by automatically creating routes from the `app` folder structure.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand Expo Router fundamentals
- Create Stack navigation
- Implement Bottom Tabs
- Implement Drawer navigation
- Understand route groups using brackets `(tabs)`
- Understand normal folders vs grouped folders
- Navigate between screens
- Design scalable navigation structure

---

# ❓ Why Expo Router?

Traditional React Navigation requires manual route configuration.

Expo Router simplifies this using:

👉 File-based routing

This means:

```text
File = Screen
Folder = Route Group
```

---

# ✅ Benefits of Expo Router

- Cleaner project structure
- Easier navigation setup
- Scalable for large applications
- Built on React Navigation
- Better developer experience

---

# ⚙️ Step 1: Install Expo Router

Install required packages:

```bash
npx expo install expo-router react-native-safe-area-context react-native-screens
```

---

# 📦 Package Overview

- `react-native-safe-area-context` helps UI avoid notches and status bars.
- `react-native-screens` improves navigation memory usage and screen performance.

---

# Install Drawer Dependencies

Drawer navigation requires additional dependencies.

```bash
npx expo install @react-navigation/drawer react-native-gesture-handler react-native-reanimated
```

---

# 📦 Drawer Package Overview

- `react-native-gesture-handler` enables gestures like drawer swipe and touch interactions.
- `react-native-reanimated` provides smooth native animations for drawers and transitions.

---

# Update `package.json`

```json
{
  "main": "expo-router/entry"
}
```

👉 This enables Expo Router as the application entry point.

---

# Configure `babel.config.js`

Drawer navigation also requires Reanimated configuration.

📁 `babel.config.js`

```js
module.exports = function (api) {
  api.cache(true);

  return {
    presets: ["babel-preset-expo"],

    plugins: ["react-native-reanimated/plugin"],
  };
};
```

👉 `react-native-reanimated/plugin` must be the last plugin.

---

# Import Gesture Handler

📁 `src/app/_layout.tsx`

```tsx
import "react-native-gesture-handler";
```

This should be imported before other navigation imports.

---

# 📁 Understanding File-based Routing

Expo Router automatically converts files into screens.

---

# Basic Example Structure

```text
src/app
│
├── _layout.tsx
├── index.tsx
├── expenses.tsx
├── settings.tsx
```

---

# Route Mapping

| File           | Route       |
| -------------- | ----------- |
| `index.tsx`    | `/`         |
| `budget.tsx`   | `/budget`   |
| `settings.tsx` | `/settings` |

---

# 🔹 What is `_layout.tsx`?

`_layout.tsx` defines the navigation structure for screens inside that folder.

It works like a parent layout.

---

# Basic Example

📁 `src/app/_layout.tsx`

```tsx
import { Stack } from "expo-router";

export default function RootLayout() {
  return <Stack />;
}
```

---

# 🧠 Understanding Navigation Types

| Navigation Type   | Purpose                        |
| ----------------- | ------------------------------ |
| Stack Navigation  | Screen-to-screen flow          |
| Tabs Navigation   | Primary application sections   |
| Drawer Navigation | Secondary side menu navigation |

---

# 📱 ExpenseApp Navigation Example

| Feature                       | Navigation Type |
| ----------------------------- | --------------- |
| Home → Budget                 | Stack           |
| Dashboard / Budget / Settings | Tabs            |
| About / Analytics / Help      | Drawer          |

---

# 🔄 Stack Navigation

Stack navigation works like a stack of screens.

---

# Example Flow

```text
Home → Budget → Back
```

---

# Basic Stack Layout

📁 `src/app/_layout.tsx`

```tsx
import { Stack } from "expo-router";

export default function RootLayout() {
  return (
    <Stack>
      <Stack.Screen name="index" options={{ title: "Home" }} />
      <Stack.Screen name="budget" options={{ title: "Budget" }} />
      <Stack.Screen name="settings" options={{ title: "Settings" }} />
    </Stack>
  );
}
```

---

# 🔗 Navigating Between Screens

Expo Router provides the `router` object for navigation.

---

# Example

Here is example codes for pages for Stack Navigation.

📁 `src/app/budget.tsx`

```tsx
import React from "react";
import { Text, View } from "react-native";
import PageTitle from "../components/page-title";
import { styles } from "../styles/styles";

export default function Budget() {
  return (
    <View style={styles.container}>
      <PageTitle title="Budget Screen"></PageTitle>
      <Text style={styles.label}>This is Budget Screen</Text>
    </View>
  );
}
```

---

📁 `src/app/settings.tsx`

```tsx
import React from "react";
import { Text, View } from "react-native";
import PageTitle from "../components/page-title";
import { styles } from "../styles/styles";

export default function Settings() {
  return (
    <View style={styles.container}>
      <PageTitle title="Settings Screen"></PageTitle>
      <Text style={styles.label}>This is Settings Screen</Text>
    </View>
  );
}
```

---

📁 `src/app/index.tsx`

```tsx
import { router } from "expo-router";
import React from "react";
import { Pressable, Text, View } from "react-native";
import PageTitle from "../components/page-title";
import { styles } from "../styles/styles";

export default function Index() {
  return (
    <View style={styles.container}>
      <PageTitle title="Home Screen"></PageTitle>
      <Text style={styles.label}>This is Home Screen</Text>

      <Pressable style={styles.button} onPress={() => router.push("/budget")}>
        <Text style={styles.buttonText}>Go to Budget</Text>
      </Pressable>

      <Pressable style={styles.button} onPress={() => router.push("/settings")}>
        <Text style={styles.buttonText}>Go to Settings</Text>
      </Pressable>
    </View>
  );
}
```

---

# 🔹 router.push()

```tsx
router.push("/budget");
```

👉 Pushes a new screen onto the stack.

---

# 📊 Bottom Tabs Navigation

Tabs are commonly used for primary application features.

---

# Example

```text
[Home] [Budget] [Settings]
```

---

# 📁 Tabs Folder Structure

```text
src/app/(tabs)
│
├── _layout.tsx
├── index.tsx
├── budget.tsx
├── settings.tsx
```

---

# ❓ Why `(tabs)` Uses Brackets?

Folders inside brackets are called:

👉 Route Groups

Examples:

```text
(auth)
(drawer)
(tabs)
(transaction)
```

These folders:

- Organize navigation
- Group screens logically
- Do NOT appear in URL/route

---

# 🔹 Difference Between Normal Folder & Grouped Folder

| Folder Type    | Example  | Appears in Route? | Purpose              |
| -------------- | -------- | ----------------- | -------------------- |
| Normal Folder  | `admin`  | Yes               | Creates route path   |
| Grouped Folder | `(tabs)` | No                | Organizes navigation |

---

# ✅ Normal Folder Example

```text
src/app/admin/users.tsx
```

Route becomes:

```text
/admin/users
```

---

# ✅ Grouped Folder Example

```text
src/app/(tabs)/index.tsx
```

Route becomes:

```text
/
```

👉 `(tabs)` is hidden from the URL.

---

# 🔹 When to Use Normal Folders?

Use normal folders when:

- Route path matters
- Creating nested routes
- Building URL hierarchy

---

# Example

```text
/reports/monthly
/profile/edit
```

---

# 🔹 When to Use Grouped Folders?

Use grouped folders when:

- Organizing navigation
- Separating layouts
- Creating tabs, drawers, or auth flows

---

To understand Tabs navigation, move all files- index.tsx, budget.tsx and settings.tsx under `app/(tabs)` folder and make the changes to `(tabs)/_layout.tsx` as follows.

# 📁 Tabs Layout

📁 `src/app/(tabs)/_layout.tsx`

```tsx
import { Tabs } from "expo-router";
import React from "react";

export default function TabLayout() {
  return (
    <Tabs>
      <Tabs.Screen name="index" options={{ title: "Home" }} />
      <Tabs.Screen name="budget" options={{ title: "Budget" }} />
      <Tabs.Screen name="settings" options={{ title: "Settings" }} />
    </Tabs>
  );
}
```

---

📁 `src/app/_layout.tsx`

```tsx
import { Stack } from "expo-router";

export default function RootLayout() {
  return <Stack screenOptions={{ headerShown: false }} />;
}
```

---

# 🔹 `headerShown: false`

```tsx
screenOptions={{ headerShown: false }}
```

👉 Hides the extra header shown above the Tabs layout.

---

# 🔹 Important Note

While moving files into `app/(tabs)`, some import paths may change automatically.

No logic changes are required.

---

# 📂 Drawer Navigation

Drawer navigation creates a side menu.

---

# Common Drawer Screens

- About
- Categories
- Settings
- Analytics
- Help

---

# 📁 Drawer Structure

```text
src/app/(drawer)
│
├── _layout.tsx
├── about.tsx
├── analytics.tsx
├── help.tsx
```

---

# Drawer Layout

📁 `src/app/(drawer)/_layout.tsx`

```tsx
import { Drawer } from "expo-router/drawer";
import React from "react";

export default function DrawerLayout() {
  return (
    <Drawer>
      <Drawer.Screen name="analytics" options={{ title: "Analytics" }} />
      <Drawer.Screen name="about" options={{ title: "About" }} />
      <Drawer.Screen name="help" options={{ title: "Help" }} />
    </Drawer>
  );
}
```

---

# 📄 About Screen

📁 `src/app/(drawer)/about.tsx`

```tsx
import PageTitle from "@/src/components/page-title";
import { styles } from "@/src/styles/styles";
import React from "react";
import { Text, View } from "react-native";

export default function About() {
  return (
    <View style={styles.container}>
      <PageTitle title="About Screen"></PageTitle>
      <Text style={styles.label}>This is About Screen</Text>
    </View>
  );
}
```

---

# ⚙️ Analytics Screen

📁 `src/app/(drawer)/analytics.tsx`

```tsx
import PageTitle from "@/src/components/page-title";
import { styles } from "@/src/styles/styles";
import React from "react";
import { Text, View } from "react-native";

export default function Analytics() {
  return (
    <View style={styles.container}>
      <PageTitle title="Analytics Screen"></PageTitle>
      <Text style={styles.label}>This is Analytics Screen</Text>
    </View>
  );
}
```

---

# ❓ Help Screen

📁 `src/app/(drawer)/help.tsx`

```tsx
import PageTitle from "@/src/components/page-title";
import { styles } from "@/src/styles/styles";
import React from "react";
import { Text, View } from "react-native";

export default function Help() {
  return (
    <View style={styles.container}>
      <PageTitle title="Help Screen"></PageTitle>
      <Text style={styles.label}>This is Help Screen</Text>
    </View>
  );
}
```

---

# 🔗 Combining Stack + Tabs + Drawer

To make Drawer hamburger visible, move `app/(tabs)` under `app/(drawer)` folder.

---

# Recommended ExpenseApp Structure

```text
src/app
│
├── _layout.tsx
│
├── (drawer)
│   ├── _layout.tsx
│   │
│   ├── (tabs)
│   │   ├── _layout.tsx
│   │   ├── index.tsx
│   │   ├── budget.tsx
│   │   └── settings.tsx
│   │
│   ├── about.tsx
│   ├── analytics.tsx
│   └── help.tsx
```

---

# Updated Root Navigation Layout

📁 `src/app/_layout.tsx`

```tsx
import { Slot } from "expo-router";
import { GestureHandlerRootView } from "react-native-gesture-handler";

export default function RootLayout() {
  return (
    <GestureHandlerRootView style={{ flex: 1 }}>
      <Slot />
    </GestureHandlerRootView>
  );
}
```

---

# Updated Tab Navigation Layout

📁 `src/app/(tabs)/_layout.tsx`

```tsx
import { Tabs } from "expo-router";
import React from "react";

export default function TabLayout() {
  return (
    <Tabs screenOptions={{ headerShown: false }}>
      <Tabs.Screen name="index" options={{ title: "Home" }} />
      <Tabs.Screen name="budget" options={{ title: "Budget" }} />
      <Tabs.Screen name="settings" options={{ title: "Settings" }} />
    </Tabs>
  );
}
```

---

# 🎨 Screen Customization

---

# Header Title

```tsx
options={{
    title: "Expense Dashboard",
}}
```

---

# Header Styling

```tsx
options={{
    headerStyle: {
        backgroundColor: "#007bff",
    },

    headerTintColor: "#fff",
}}
```

---

# Hide Header

```tsx
options={{
    headerShown: false,
}}
```

---

# 🔄 Navigation Flow in ExpenseApp

---

# Main Features (Tabs)

```text
[Home] [Budget] [Settings]
```

---

# Secondary Features (Drawer)

```text
Home
About
Analytics
Help
```

---

# ✅ Best Practices

- Use Tabs for primary screens
- Use Drawer for secondary features
- Use Stack for screen transitions
- Keep navigation structure simple
- Avoid deeply nested folders
- Use grouped folders for organization

---

# ⚠️ Common Mistakes

- Forgetting to create `_layout.tsx` inside route groups
- Mixing grouped folders and normal folders incorrectly
- Creating deeply nested navigation unnecessarily
- Forgetting Drawer dependencies installation

---

# 🧪 Practice Exercises

1. Add a new `reports.tsx` screen inside `(drawer)`
2. Create a new tab screen named `profile.tsx`
3. Add navigation from Dashboard to Settings screen
4. Customize Tabs header background color

---

# 📘 Chapter Summary

In this chapter, you:

- Learned Expo Router fundamentals
- Implemented Stack navigation
- Implemented Bottom Tabs
- Implemented Drawer navigation
- Understood grouped folders `(tabs)`
- Learned normal vs grouped folders
- Navigated between screens
- Designed scalable navigation flow for ExpenseApp
