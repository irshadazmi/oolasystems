# Chapter 15: Dynamic Bottom Tabs & Drawer Navigation

---

In previous chapters, we learned:

- Stack Navigation
- Bottom Tab Navigation
- Drawer Navigation

Until now, our navigation structure was mostly static.

In real-world applications, navigation menus are often generated dynamically using configuration data.

Examples:

- Banking apps show dynamic menu items
- E-commerce apps enable/disable tabs
- Admin panels load menus based on permissions

In this chapter, we will build:

✅ Dynamic Bottom Tabs
✅ Dynamic Drawer Navigation
✅ Reusable Navigation Components
✅ Centralized Navigation Configuration

using simple and beginner-friendly architecture for ExpenseApp.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Create dynamic tab navigation
- Create dynamic drawer navigation
- Use reusable navigation configuration
- Navigate using Expo Router
- Highlight active tabs
- Open and close custom drawer
- Create reusable navigation components
- Structure scalable navigation systems

---

# 🔹 Why Dynamic Navigation?

Instead of hardcoding menu items repeatedly, we can store navigation configuration in separate files.

Benefits:

✅ Cleaner code
✅ Easier maintenance
✅ Reusable navigation
✅ Easier scalability
✅ Centralized configuration

---

# 🔹 Navigation Architecture

```text
TAB_ITEMS.ts
        ↓
Custom TabBar
        ↓
Bottom Navigation

DRAWER_ITEMS.ts
        ↓
Custom Drawer
        ↓
Side Menu Navigation
```

---

# 🔹 Create Dynamic Tab Configuration

📁 `src/constants/TAB_ITEMS.ts`

```tsx
export const TAB_ITEMS = [
    {
        name: "(dashboard)",
        title: "Dashboard",
        icon: "🏠",
    },

    {
        name: "(budget)",
        title: "Budget",
        icon: "💰",
    },

    {
        name: "(insights)",
        title: "Insights",
        icon: "🧠",
    },

    {
        name: "(menu)",
        title: "Menu",
        icon: "☰",
    },
];
```

---

# 🔹 Create Drawer Configuration

📁 `src/constants/DRAWER_ITEMS.ts`

```tsx
export const DRAWER_ITEMS = [
    {
        name: "(dashboard)",
        title: "Dashboard",
        icon: "🏠",
    },

    {
        name: "(category)",
        title: "Category",
        icon: "🏷️",
    },

    {
        name: "(account)",
        title: "Account",
        icon: "👤",
    },

    {
        name: "(budget)",
        title: "Budget",
        icon: "💰",
    },

    {
        name: "(transaction)",
        title: "Transaction",
        icon: "💳",
    },

    {
        name: "(insights)",
        title: "AI Insights",
        icon: "🧠",
    },

    {
        name: "(settings)",
        title: "Settings",
        icon: "⚙️",
    },

    {
        name: "(about)",
        title: "About",
        icon: "ℹ️",
    },
];
```

---

# 🔹 Recommended Folder Structure

```text
src
│
├── app
│   ├── _layout.tsx
│   ├── (dashboard)
│   ├── (budget)
│   ├── (insights)
│   └── (settings)
│
├── components
│   ├── tab-bar.tsx
│   └── custom-drawer.tsx
│
├── constants
│   ├── TAB_ITEMS.ts
│   └── DRAWER_ITEMS.ts
│
└── styles
    └── styles.ts
```

---

# 🔹 Update Existing External Styles

📁 `src/styles/styles.ts`

Add the following styles inside existing `style` object:

```tsx
tabBar: {
    flexDirection: "row",
    height: 60,
    borderTopWidth: 1,
    borderColor: "#ddd",
    backgroundColor: "#fff",
},

tabItem: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
},

tabIcon: {
    fontSize: 20,
},

tabLabel: {
    fontSize: 13,
    color: "#888",
},

activeTabLabel: {
    color: "#000",
    fontWeight: "700",
},

header: {
    height: 60,
    backgroundColor: "#333",
    justifyContent: "center",
    paddingHorizontal: 20,
},

headerTitle: {
    color: "#fff",
    fontSize: 20,
    fontWeight: "700",
},

screenContainer: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
},

screenText: {
    fontSize: 18,
},

backdrop: {
    flex: 1,
    backgroundColor: "rgba(0,0,0,0.4)",
    justifyContent: "center",
},

drawerContainer: {
    width: "75%",
    backgroundColor: "#fff",
    padding: 20,
},

drawerItem: {
    flexDirection: "row",
    alignItems: "center",
    paddingVertical: 15,
},

drawerIcon: {
    fontSize: 20,
    marginRight: 10,
},

drawerText: {
    fontSize: 16,
    color: "#666",
},

activeDrawerText: {
    color: "#000",
    fontWeight: "700",
},
```

---

# 🔹 Understanding Expo Router Segments

Expo Router provides route segments using:

```tsx
useSegments();
```

Example route:

```text
/(budget)
```

Segment value:

```text
(budget)
```

This helps identify the currently active tab or drawer item.

---

# 🔹 Create Custom Tab Bar

📁 `src/components/tab-bar.tsx`

```tsx
import React from "react";

import { View, Text, Pressable } from "react-native";

import { useRouter, useSegments } from "expo-router";

import { TAB_ITEMS } from "../constants/TAB_ITEMS";

import { style } from "../styles/styles";

type Props = {
    onMenuPress: () => void;
};

export default function TabBar({ onMenuPress }: Props) {
    const router = useRouter();

    const segments = useSegments();

    const currentTab = segments[0] || "(dashboard)";

    return (
        <View style={styles.tabBar}>
            {TAB_ITEMS.map((item) => {
                const isActive = currentTab === item.name;

                const handlePress = () => {
                    if (item.name === "(menu)") {
                        onMenuPress();
                        return;
                    }

                    router.replace(`/${item.name}`);
                };

                return (
                    <Pressable
                        key={item.name}
                        onPress={handlePress}
                        style={styles.tabItem}
                    >
                        <Text style={styles.tabIcon}>{item.icon}</Text>

                        <Text
                            style={[
                                styles.tabLabel,

                                isActive && styles.activeTabLabel,
                            ]}
                        >
                            {item.title}
                        </Text>
                    </Pressable>
                );
            })}
        </View>
    );
}
```

---

# 🔹 How Dynamic Tabs Work

The tab bar:

1. Reads items from `TAB_ITEMS`
2. Loops using `.map()`
3. Creates tabs dynamically
4. Detects active tab
5. Navigates using Expo Router

---

# 🔹 Create Custom Drawer

📁 `src/components/custom-drawer.tsx`

```tsx
import React from "react";

import { Modal, Pressable, Text, View } from "react-native";

import { useRouter, useSegments } from "expo-router";

import { DRAWER_ITEMS } from "../constants/DRAWER_ITEMS";

import { style } from "../styles/styles";

type Props = {
    visible: boolean;
    onClose: () => void;
};

export default function CustomDrawer({ visible, onClose }: Props) {
    const router = useRouter();

    const segments = useSegments();

    const currentRoute = segments[0] || "(dashboard)";

    return (
        <Modal visible={visible} transparent animationType="slide">
            <Pressable style={styles.backdrop} onPress={onClose}>
                <View style={styles.drawerContainer}>
                    {DRAWER_ITEMS.map((item) => {
                        const isActive = currentRoute === item.name;

                        return (
                            <Pressable
                                key={item.name}
                                onPress={() => {
                                    onClose();

                                    router.replace(`/${item.name}`);
                                }}
                                style={styles.drawerItem}
                            >
                                <Text style={styles.drawerIcon}>
                                    {item.icon}
                                </Text>

                                <Text
                                    style={[
                                        styles.drawerText,

                                        isActive && styles.activeDrawerText,
                                    ]}
                                >
                                    {item.title}
                                </Text>
                            </Pressable>
                        );
                    })}
                </View>
            </Pressable>
        </Modal>
    );
}
```

---

# 🔹 How Dynamic Drawer Works

The drawer:

1. Reads items from `DRAWER_ITEMS`
2. Loops dynamically
3. Detects active route
4. Navigates using router
5. Closes automatically after selection

---

# 🔹 Create Root Layout

📁 `src/app/_layout.tsx`

```tsx
import React, { useState } from "react";

import { SafeAreaView, Text, View } from "react-native";

import { Slot } from "expo-router";

import TabBar from "../components/tab-bar";

import CustomDrawer from "../components/custom-drawer";

import { style } from "../styles/styles";

export default function RootLayout() {
    const [drawerVisible, setDrawerVisible] = useState(false);

    return (
        <SafeAreaView style={styles.container}>
            {/* Header */}

            <View style={styles.header}>
                <Text style={styles.headerTitle}>ExpenseApp</Text>
            </View>

            {/* Screen Content */}

            <View style={styles.container}>
                <Slot />
            </View>

            {/* Bottom Tabs */}

            <TabBar onMenuPress={() => setDrawerVisible(true)} />

            {/* Drawer */}

            <CustomDrawer
                visible={drawerVisible}
                onClose={() => setDrawerVisible(false)}
            />
        </SafeAreaView>
    );
}
```

---

# 🔹 Create Simple Screens

📁 `src/app/(dashboard)/index.tsx`

```tsx
import React from "react";

import { Text, View } from "react-native";

import { style } from "../../styles/styles";

export default function DashboardScreen() {
    return (
        <View style={styles.screenContainer}>
            <Text style={styles.screenText}>Dashboard Screen</Text>
        </View>
    );
}
```

---

📁 `src/app/(budget)/index.tsx`

```tsx
import React from "react";

import { Text, View } from "react-native";

import { style } from "../../styles/styles";

export default function BudgetScreen() {
    return (
        <View style={styles.screenContainer}>
            <Text style={styles.screenText}>Budget Screen</Text>
        </View>
    );
}
```

---

# 🔹 Active Tab Highlighting

We detect active screen using:

```tsx
const currentTab = segments[0];
```

Then compare:

```tsx
const isActive = currentTab === item.name;
```

This helps:

✅ Highlight active tab
✅ Highlight active drawer item
✅ Improve user experience

---

# 🔹 Why Use External Styles?

Benefits:

✅ Cleaner components
✅ Reusable styles
✅ Better maintainability
✅ Consistent UI
✅ Easier scaling

---

# 🔹 Dynamic Navigation Flow

```text
User Presses Tab
        ↓
TabBar Detects Item
        ↓
router.replace()
        ↓
Expo Router Changes Screen
        ↓
Active Tab Updates
```

---

# ✅ Best Practices

✅ Keep navigation config separate
✅ Use reusable components
✅ Use external styles
✅ Keep navigation dynamic
✅ Use Expo Router properly
✅ Highlight active screens
✅ Avoid duplicate navigation code

---

# ⚠️ Common Mistakes

❌ Hardcoding tabs everywhere
❌ Mixing styles inside components
❌ Mixing navigation with business logic
❌ Not highlighting active tab
❌ Repeating navigation items manually

---

# 🧪 Practice Exercises

1. Add badge counts to tabs
2. Add logout item in drawer
3. Add profile screen
4. Add theme toggle in header
5. Add active drawer background color
6. Add Expo Vector Icons
7. Add drawer open animation

---

# 📘 Chapter Summary

In this chapter, you:

✅ Built dynamic bottom tabs
✅ Built dynamic drawer navigation
✅ Used centralized configuration
✅ Used Expo Router navigation
✅ Created reusable navigation components
✅ Used external styles
✅ Highlighted active tabs and drawer items
✅ Structured scalable navigation architecture
