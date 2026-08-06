# Chapter 19: Animations & Microinteractions

---

In previous chapters, we learned:

- Navigation
- Device APIs
- Notifications
- Async Operations
- Context API

Modern mobile applications also use animations and microinteractions to create smoother and more engaging user experiences.

Examples:

- Button press feedback
- Smooth screen transitions
- Animated expense cards
- Loading transitions
- Expanding sections

Animations help applications feel:

✅ Smooth
✅ Responsive
✅ Interactive
✅ Modern

In this chapter, we will use:

✅ LayoutAnimation
✅ Animated API
✅ Opacity Animations
✅ Transform Animations
✅ Gesture-Friendly Interactions

to improve ExpenseApp user experience.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand animation fundamentals
- Use LayoutAnimation
- Use Animated API
- Create fade and transform animations
- Create button microinteractions
- Animate ExpenseApp components
- Improve user experience using animations
- Understand animation performance considerations

---

# 🎬 Why Animations Matter

Animations are not only visual effects.

They improve usability and interaction quality.

---

# 🔹 Benefits of Animations

Animations help:

✅ Provide feedback
✅ Improve perceived performance
✅ Guide user attention
✅ Create smoother transitions
✅ Make UI feel natural

---

# 🔹 When to Use Animations

Good use cases:

- Button press feedback
- Loading indicators
- Expanding cards
- List updates
- Screen transitions

---

# 🔹 Avoid Excessive Animations

Too many animations can:

❌ Distract users
❌ Reduce performance
❌ Make UI confusing

Animations should enhance usability, not reduce it.

---

# 🔹 Types of Animations in React Native

| Type               | Purpose                      |
| ------------------ | ---------------------------- |
| LayoutAnimation    | Automatic layout transitions |
| Animated API       | Custom animations            |
| Gesture Animations | Touch interactions           |

---

# 🧩 LayoutAnimation

---

# 🔹 What is LayoutAnimation?

`LayoutAnimation` automatically animates layout changes.

Examples:

- Adding items
- Removing items
- Expanding views
- Collapsing sections

---

# 🔹 Why Use LayoutAnimation?

Without animation:

❌ UI changes suddenly

With animation:

✅ Smooth transitions

---

# 🔹 Basic Example

```tsx id="n5mwte"
import { LayoutAnimation } from "react-native";

const toggleSection = () => {
    LayoutAnimation.easeInEaseOut();

    setExpanded(!expanded);
};
```

---

# 🔹 ExpenseApp Example

📁 `src/app/index.tsx`

```tsx id="zn2rjv"
import { LayoutAnimation } from "react-native";

const handleAddExpense = () => {
    LayoutAnimation.configureNext(LayoutAnimation.Presets.easeInEaseOut);

    setExpenses((prev) => [...prev, newExpense]);
};
```

---

# 🔹 Common Presets

| Preset        | Effect            |
| ------------- | ----------------- |
| easeInEaseOut | Smooth transition |
| linear        | Constant speed    |
| spring        | Bouncy effect     |

---

# 🎞️ Animated API

---

# 🔹 What is Animated API?

`Animated` API provides fine-grained animation control.

It supports:

- Opacity
- Movement
- Rotation
- Scaling
- Interpolation

---

# 🔹 Creating Animated Value

```tsx id="0k7pj2"
import { Animated } from "react-native";

const fadeAnim = new Animated.Value(0);
```

---

# 🔹 Why Animated.Value?

It stores animation state.

Examples:

- Current opacity
- Current position
- Current scale

---

# 🔹 Fade In Animation

```tsx id="e2bn1s"
Animated.timing(fadeAnim, {
    toValue: 1,

    duration: 500,

    useNativeDriver: true,
}).start();
```

---

# 🔹 Why useNativeDriver?

```tsx id="fjlwmw"
useNativeDriver: true;
```

moves animation execution to native thread.

Benefits:

✅ Smoother animations
✅ Better performance
✅ Reduced lag

---

# 🔹 Apply Animation

```tsx id="d8e55r"
<Animated.View
    style={{
        opacity: fadeAnim,
    }}
>
    <Text>Hello</Text>
</Animated.View>
```

---

# 🌫️ Opacity Animation

Opacity controls visibility.

| Value | Meaning       |
| ----- | ------------- |
| 0     | Invisible     |
| 1     | Fully visible |

---

# 🔹 ExpenseApp Fade-In Card

📁 `src/components/expense-item.tsx`

```tsx id="5j6m76"
import React, { useEffect, useRef } from "react";

import { Animated, Text, View } from "react-native";

import { style } from "../styles/styles";

type Props = {
    description: string;
    amount: number;
};

export default function ExpenseItem({ description, amount }: Props) {
    const fadeAnim = useRef(new Animated.Value(0)).current;

    useEffect(() => {
        Animated.timing(fadeAnim, {
            toValue: 1,

            duration: 500,

            useNativeDriver: true,
        }).start();
    }, []);

    return (
        <Animated.View
            style={[
                styles.card,
                {
                    opacity: fadeAnim,
                },
            ]}
        >
            <Text style={styles.description}>{description}</Text>

            <Text style={styles.amount}>₹{amount}</Text>
        </Animated.View>
    );
}
```

---

# 🔄 Transform Animations

Transform animations modify:

- Position
- Rotation
- Scale

---

# 🔹 Translate Animation

Moves component position.

---

## Example

```tsx id="i2cbv7"
const translateY = new Animated.Value(100);

Animated.timing(translateY, {
    toValue: 0,

    duration: 500,

    useNativeDriver: true,
}).start();
```

---

# 🔹 Apply Translate Animation

```tsx id="wbw9wv"
<Animated.View
    style={{
        transform: [
            { translateY },
        ],
    }}
>
```

---

# 🔹 Scale Animation

Scale changes component size.

---

## Example

```tsx id="t1ew9n"
const scaleAnim = new Animated.Value(1);

Animated.spring(scaleAnim, {
    toValue: 1.1,

    useNativeDriver: true,
}).start();
```

---

# 🔹 Why Scale Animation?

Used for:

- Button feedback
- Card interactions
- Press animations

---

# 👆 Gesture-Friendly Animations

Modern applications respond visually to user gestures.

Examples:

- Tap
- Swipe
- Drag
- Long press

---

# 🔹 Press Feedback Animation

📁 `src/components/animated-button.tsx`

```tsx id="bxy8gi"
import React, { useRef } from "react";

import { Animated, Pressable, Text } from "react-native";

import { style } from "../styles/styles";

type Props = {
    title: string;
    onPress: () => void;
};

export default function AnimatedButton({ title, onPress }: Props) {
    const scaleAnim = useRef(new Animated.Value(1)).current;

    const handlePressIn = () => {
        Animated.spring(scaleAnim, {
            toValue: 0.95,

            useNativeDriver: true,
        }).start();
    };

    const handlePressOut = () => {
        Animated.spring(scaleAnim, {
            toValue: 1,

            useNativeDriver: true,
        }).start();
    };

    return (
        <Pressable
            onPressIn={handlePressIn}
            onPressOut={handlePressOut}
            onPress={onPress}
        >
            <Animated.View
                style={[
                    styles.button,
                    {
                        transform: [
                            {
                                scale: scaleAnim,
                            },
                        ],
                    },
                ]}
            >
                <Text style={styles.buttonText}>{title}</Text>
            </Animated.View>
        </Pressable>
    );
}
```

---

# 🔹 Microinteractions

Microinteractions are small animations responding to user actions.

Examples:

- Button press effect
- Toggle animation
- Loading spinner
- Card expansion

---

# 🔹 Why Microinteractions Matter

Benefits:

✅ Better feedback
✅ Better engagement
✅ Better responsiveness
✅ More polished UI

---

# 🧪 ExpenseApp Example

📁 `src/app/index.tsx`

```tsx id="j6mlku"
import React, { useState } from "react";

import { View, FlatList, LayoutAnimation } from "react-native";

import ExpenseItem from "../components/expense-item";

import AnimatedButton from "../components/animated-button";

import { style } from "../styles/styles";

export default function HomeScreen() {
    const [expenses, setExpenses] = useState([
        {
            id: 1,
            description: "Food",
            amount: 200,
        },
    ]);

    const addExpense = () => {
        LayoutAnimation.configureNext(LayoutAnimation.Presets.easeInEaseOut);

        setExpenses((prev) => [
            ...prev,
            {
                id: Date.now(),
                description: "Travel",
                amount: 500,
            },
        ]);
    };

    return (
        <View style={styles.container}>
            <AnimatedButton title="Add Expense" onPress={addExpense} />

            <FlatList
                data={expenses}
                keyExtractor={(item) => item.id.toString()}
                renderItem={({ item }) => (
                    <ExpenseItem
                        description={item.description}
                        amount={item.amount}
                    />
                )}
            />
        </View>
    );
}
```

---

# 🔹 Animation Flow

```text id="n9v8ek"
User Presses Button
          ↓
Animation Starts
          ↓
State Updates
          ↓
UI Re-renders Smoothly
```

---

# ⚡ Performance Considerations

Animations should remain lightweight.

---

# 🔹 Performance Tips

✅ Use `useNativeDriver`

✅ Avoid animating many elements simultaneously

✅ Prefer simple animations

✅ Avoid unnecessary re-renders

✅ Test animations on real devices

---

# 🔹 When to Animate

Use animations for:

✅ Feedback
✅ Transitions
✅ Important interactions
✅ Improved perceived performance

---

# 🔹 When NOT to Animate

Avoid animations when:

❌ They slow interaction
❌ They distract users
❌ They add no UX value

---

# 🔹 Recommended Folder Structure

```text id="1cjlwm"
src
│
├── app
│   └── index.tsx
│
├── components
│   ├── expense-item.tsx
│   └── animated-button.tsx
│
├── hooks
│   └── use-animation.ts
│
└── styles
    └── styles.ts
```

---

# ✅ Best Practices

✅ Keep animations subtle
✅ Use consistent durations
✅ Prefer reusable animation components
✅ Use microinteractions thoughtfully
✅ Keep animations smooth and meaningful

---

# ⚠️ Common Mistakes

❌ Overusing animations
❌ Forgetting `useNativeDriver`
❌ Heavy animations causing lag
❌ Animating too many components
❌ Complex animations for simple actions

---

# 🧪 Practice Exercises

1. Add animated expense deletion
2. Add expandable expense card
3. Add loading spinner animation
4. Add swipe-to-delete interaction
5. Create reusable fade-in component
6. Add animated tab transitions
7. Create custom animation hook

---

# 📘 Chapter Summary

In this chapter, you:

✅ Learned animation fundamentals
✅ Used LayoutAnimation
✅ Used Animated API
✅ Built fade and transform animations
✅ Added button microinteractions
✅ Animated ExpenseApp components
✅ Improved user experience
✅ Learned animation performance optimization
