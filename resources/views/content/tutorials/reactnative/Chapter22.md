# Chapter 22: Theme Context & Dark Mode

---

In previous chapters, we built several ExpenseApp features using:

- Navigation
- Context API
- AsyncStorage
- Notifications
- Device APIs
- Animations
- TypeScript

Modern mobile applications also support:

✅ Light Mode
✅ Dark Mode
✅ System Theme Detection

Users now expect applications to automatically adapt to their device theme settings.

Examples:

- Banking apps support dark mode
- Social media apps switch themes automatically
- Expense apps improve readability in dark environments

In this chapter, we will build a simple and reusable Theme Context system for ExpenseApp using:

✅ React Context API
✅ AsyncStorage
✅ useColorScheme()
✅ Dynamic Styles
✅ Theme Toggle Button

The implementation is simplified and optimized from your existing production version for easier learning and understanding.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand theming in React Native
- Create Theme Context
- Support light and dark themes
- Detect system theme automatically
- Save theme using AsyncStorage
- Create dynamic styles
- Use reusable theme colors
- Build a theme toggle button

---

# ⚡ Why Themes Matter

Themes improve:

✅ User experience
✅ Accessibility
✅ Readability
✅ Battery efficiency (OLED screens)

---

# 🔹 Real ExpenseApp Benefits

Dark mode is useful for:

- Night usage
- Reduced eye strain
- Better visual comfort
- Modern UI appearance

---

# 🔹 Theme Flow

```text
User Changes Theme
          ↓
Theme Context Updates
          ↓
Colors Change
          ↓
UI Re-renders Automatically
```

---

# 🔹 Create Theme Colors

📁 `src/constants/theme.ts`

```tsx
export const COLORS = {
    light: {
        background: "#ffffff",
        card: "#f4f4f4",
        text: "#222222",
        primary: "#007bff",
        buttonText: "#ffffff",
    },

    dark: {
        background: "#121212",
        card: "#1e1e1e",
        text: "#ffffff",
        primary: "#4d94ff",
        buttonText: "#ffffff",
    },
};

export const getColors = (mode: "light" | "dark") => {
    return COLORS[mode];
};
```

---

# 🔹 Understanding Theme Colors

We separate:

✅ Light colors

✅ Dark colors

This keeps UI centralized and reusable.

---

# 🔹 Create Theme Context

📁 `src/contexts/theme-context.tsx`

```tsx
import React, { createContext, useContext, useEffect, useState } from "react";

import AsyncStorage from "@react-native-async-storage/async-storage";

import { useColorScheme } from "react-native";

import { getColors } from "../constants/theme";

type ThemeMode = "light" | "dark" | "system";

type ThemeContextType = {
    mode: ThemeMode;

    theme: "light" | "dark";

    colors: ReturnType<typeof getColors>;

    toggleTheme: () => void;
};

const ThemeContext = createContext<ThemeContextType | undefined>(undefined);

export const ThemeProvider = ({ children }: { children: React.ReactNode }) => {
    const systemTheme = useColorScheme();

    const [mode, setMode] = useState<ThemeMode>("system");

    /* Load Saved Theme */

    useEffect(() => {
        (async () => {
            const saved = await AsyncStorage.getItem("theme");

            if (saved === "light" || saved === "dark" || saved === "system") {
                setMode(saved);
            }
        })();
    }, []);

    /* Resolve Final Theme */

    const theme =
        mode === "system" ? (systemTheme === "dark" ? "dark" : "light") : mode;

    /* Toggle Theme */

    const toggleTheme = async () => {
        const next = theme === "light" ? "dark" : "light";

        setMode(next);

        await AsyncStorage.setItem("theme", next);
    };

    return (
        <ThemeContext.Provider
            value={{
                mode,
                theme,
                colors: getColors(theme),
                toggleTheme,
            }}
        >
            {children}
        </ThemeContext.Provider>
    );
};

export const useTheme = () => {
    const context = useContext(ThemeContext);

    if (!context) {
        throw new Error("useTheme must be used inside ThemeProvider");
    }

    return context;
};
```

---

# 🔹 Why Context API?

Theme must be accessible globally.

Using Context API allows:

✅ Global theme access

✅ Automatic UI updates

✅ Cleaner architecture

---

# 🔹 useColorScheme()

React Native provides:

```tsx
useColorScheme();
```

It detects:

✅ Light mode

✅ Dark mode

from device settings automatically.

---

# 🔹 AsyncStorage Integration

We save theme using:

```tsx
AsyncStorage.setItem();
```

This preserves theme after application restart.

---

# 🔹 Create Dynamic Styles

📁 `src/styles/styles.ts`

Simplified version using theme context:

```tsx
import { StyleSheet } from "react-native";

import { useTheme } from "../contexts/theme-context";

export const useStyles = () => {
    const { colors } = useTheme();

    return StyleSheet.create({
        container: {
            flex: 1,
            padding: 20,
            backgroundColor: colors.background,
        },

        title: {
            fontSize: 24,
            fontWeight: "700",
            marginBottom: 20,
            color: colors.text,
            textAlign: "center",
        },

        card: {
            padding: 15,
            borderRadius: 10,
            marginBottom: 10,
            backgroundColor: colors.card,
        },

        text: {
            fontSize: 16,
            color: colors.text,
        },

        button: {
            backgroundColor: colors.primary,
            padding: 12,
            marginBottom: 20,
            alignItems: "center",
            borderRadius: 8,
        },

        buttonText: {
            color: colors.buttonText,

            fontWeight: "600",
        },

        header: {
            height: 60,

            backgroundColor: colors.primary,

            justifyContent: "center",

            alignItems: "center",
        },

        headerText: {
            color: colors.buttonText,

            fontSize: 20,

            fontWeight: "700",
        },
    });
};
```

---

# 🔹 Why Dynamic Styles?

Without dynamic styles:

❌ Colors stay fixed

With dynamic styles:

✅ UI updates automatically when theme changes

---

# 🔹 Create App Header

📁 `src/components/app-header.tsx`

```tsx
import React from "react";

import { View, Text, Pressable } from "react-native";

import { useTheme } from "../contexts/theme-context";

import { useStyles } from "../styles/styles";

export default function AppHeader() {
    const { theme, toggleTheme } = useTheme();

    const style = useStyles();

    return (
        <View style={styles.header}>
            <Text style={styles.headerText}>ExpenseApp</Text>

            <Pressable
                onPress={toggleTheme}
                style={{
                    position: "absolute",

                    right: 20,
                }}
            >
                <Text
                    style={{
                        color: "#fff",
                    }}
                >
                    {theme === "light" ? "🌙" : "☀️"}
                </Text>
            </Pressable>
        </View>
    );
}
```

---

# 🔹 Why Keep Header Simple?

We intentionally keep the theme switch simple:

✅ Easier to understand

✅ Less styling complexity

✅ Beginner-friendly

Later chapters can introduce:

- Icons
- Animated toggles
- Multiple theme options

---

# 🔹 Wrap Root Layout

📁 `src/app/_layout.tsx`

```tsx
import { Slot } from "expo-router";

import { ThemeProvider } from "../contexts/theme-context";

export default function Layout() {
    return (
        <ThemeProvider>
            <Slot />
        </ThemeProvider>
    );
}
```

---

# 🔹 Use Theme in Screens

📁 `src/app/index.tsx`

```tsx
import React from "react";

import { View, Text } from "react-native";

import AppHeader from "../components/app-header";

import { useStyles } from "../styles/styles";

export default function HomeScreen() {
    const style = useStyles();

    return (
        <View style={styles.container}>
            <AppHeader />

            <View style={styles.card}>
                <Text style={styles.text}>Welcome to ExpenseApp</Text>
            </View>
        </View>
    );
}
```

---

# 🔹 Theme Switching Flow

```text
User Presses Toggle
          ↓
toggleTheme() Executes
          ↓
Theme Context Updates
          ↓
Styles Recalculate
          ↓
UI Automatically Updates
```

---

# 🔹 Light vs Dark Theme

| Theme | Background | Text  |
| ----- | ---------- | ----- |
| Light | White      | Dark  |
| Dark  | Dark       | White |

---

# 🔹 Why Use useStyles Hook?

Using:

```tsx
useStyles();
```

helps:

✅ Centralize styles

✅ Dynamically apply colors

✅ Reuse styles everywhere

---

# 🔹 Recommended Folder Structure

```text
src
│
├── app
│   ├── _layout.tsx
│   └── index.tsx
│
├── components
│   └── app-header.tsx
│
├── constants
│   └── theme.ts
│
├── contexts
│   └── theme-context.tsx
│
└── styles
    └── styles.ts
```

---

# ⚡ Performance Considerations

✅ Keep themes centralized

✅ Avoid recreating unnecessary objects

✅ Reuse color definitions

✅ Keep styles minimal

---

# 🔐 Best Practices

✅ Use Context API for global themes
✅ Store theme in AsyncStorage
✅ Keep colors centralized
✅ Use reusable style hooks
✅ Keep dark mode readable

---

# ⚠️ Common Mistakes

❌ Hardcoding colors everywhere
❌ Duplicating styles
❌ Not saving theme preferences
❌ Mixing light/dark logic inside components
❌ Large complex theme objects for small apps

---

# 🧪 Practice Exercises

1. Add System theme support UI
2. Add separate Settings screen for theme
3. Add dark mode to TabBar
4. Add dark mode to Drawer
5. Add animated theme transition
6. Add reusable themed button component
7. Create custom useColors hook

---

# 📘 Chapter Summary

In this chapter, you:

✅ Built Theme Context
✅ Added light and dark mode
✅ Used AsyncStorage for persistence
✅ Used useColorScheme()
✅ Created dynamic styles
✅ Built reusable theme architecture
✅ Added theme toggle functionality
✅ Improved ExpenseApp user experience
