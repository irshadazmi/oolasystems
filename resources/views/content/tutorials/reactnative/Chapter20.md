# Chapter 20: Performance Optimization

---

In this chapter, we focus on improving the **performance, responsiveness, and scalability** of our React Native application.

As ExpenseApp grows (more users, more transactions), inefficient rendering and poor list handling can lead to:

- Slow scrolling
- UI lag
- Battery drain
- Poor user experience

This chapter teaches how to **optimize rendering, lists, and component behavior** using real-world patterns.

---

## 🎯 What You Will Learn

By the end of this chapter, you will:

- Optimize large lists using FlatList properties
- Prevent unnecessary re-renders
- Use `React.memo` for component optimization
- Use `useMemo` and `useCallback` correctly
- Apply optimization techniques in ExpenseApp

---

# ⚡ Why Performance Optimization Matters

---

### 🔹 Real Problem in ExpenseApp

Imagine:

- 5,000+ expense records
- Each render recalculates totals
- Each item re-renders unnecessarily

👉 Result:

- Laggy scrolling
- Poor UX

---

### 🔹 Goal

👉 Render only what is needed
👉 Avoid repeated calculations
👉 Keep UI smooth and responsive

---

# 📜 FlatList Optimization (Core Area)

FlatList is optimized, but requires **correct configuration** for best performance.

---

## 🔹 keyExtractor (MANDATORY)

```tsx id="pfl1"
keyExtractor={(item) => item.id.toString()}
```

### Why Important?

- Helps React identify items uniquely
- Prevents unnecessary re-renders
- Improves diffing performance

👉 In ExpenseApp:
Each expense must have a **stable unique ID**

---

## 🔹 initialNumToRender

```tsx id="pfl2"
initialNumToRender={10}
```

### Explanation

- Number of items rendered initially
- Smaller value → faster screen load
- Larger value → smoother initial scroll

👉 ExpenseApp Tip:

- Use **8–12** for typical lists

---

## 🔹 getItemLayout (Huge Performance Boost)

```tsx id="pfl3"
getItemLayout={(data, index) => ({
  length: 70,
  offset: 70 * index,
  index,
})}
```

### Why Important?

- Skips layout measurement
- Improves scroll performance
- Required for large datasets

👉 Use only when:

- Items have **fixed height**

---

## 🔹 removeClippedSubviews

```tsx id="pfl4"
removeClippedSubviews={true}
```

### Explanation

- Removes off-screen items from memory
- Reduces memory usage

👉 Important for:

- Long expense lists

---

## 🔹 windowSize

```tsx id="pfl5"
windowSize={5}
```

### Explanation

- Controls how many items are rendered around viewport

👉 Smaller value:

- Less memory
  👉 Larger value:
- Smoother scrolling

---

## 🧪 ExpenseApp Optimized List

```tsx id="pfl6"
<FlatList
    data={expenses}
    keyExtractor={(item) => item.id.toString()}
    renderItem={renderItem}
    initialNumToRender={10}
    getItemLayout={(data, index) => ({
        length: 70,
        offset: 70 * index,
        index,
    })}
    removeClippedSubviews
/>
```

---

# 🔁 Avoiding Unnecessary Re-renders

---

## 🔹 What Causes Re-renders?

- State changes
- Parent re-render
- New function/object references

👉 Even if UI doesn’t change → React re-renders

---

## 🔹 ExpenseApp Problem Example

```tsx id="rer1"
<FlatList renderItem={({ item }) => <ExpenseItem {...item} />} />
```

👉 Problem:

- Function recreated every render
- All items re-render

---

# 🧩 React.memo

---

## 🔹 What is React.memo?

Prevents re-render if props are unchanged.

---

### Example

```tsx id="rm1"
const ExpenseItem = React.memo(({ title, amount }) => {
    console.log("Rendering:", title);

    return (
        <Text>
            {title}: ₹{amount}
        </Text>
    );
});
```

---

### Why Important?

👉 In ExpenseApp:

- Only changed items re-render
- Others remain untouched

---

## 🔹 When NOT to Use

- Very small components
- Frequently changing props

---

# 🧠 useMemo

---

## 🔹 What is useMemo?

Caches computed values to avoid recalculating.

---

## 🔹 ExpenseApp Problem

```tsx id="umprob"
const total = expenses.reduce((sum, item) => sum + item.amount, 0);
```

👉 Runs on every render

---

## 🔹 Optimized Version

```tsx id="um1"
const total = useMemo(() => {
    return expenses.reduce((sum, item) => sum + item.amount, 0);
}, [expenses]);
```

---

### Why Important?

👉 Recalculates only when expenses change

---

## 🔹 Real Use Cases

- Total calculation
- Filtering expenses
- Sorting data

---

# 🔄 useCallback

---

## 🔹 What is useCallback?

Caches functions to avoid re-creation.

---

## 🔹 ExpenseApp Problem

```tsx id="ucprob"
const renderItem = ({ item }) => <ExpenseItem {...item} />;
```

👉 New function created every render

---

## 🔹 Optimized Version

```tsx id="uc1"
const renderItem = useCallback(({ item }) => <ExpenseItem {...item} />, []);
```

---

### Why Important?

- Keeps function reference stable
- Works with React.memo

---

# 🧪 Combined Optimization Example

```tsx id="combo1"
const renderItem = useCallback(({ item }) => <ExpenseItem {...item} />, []);

const total = useMemo(() => {
    return expenses.reduce((sum, item) => sum + item.amount, 0);
}, [expenses]);

<FlatList
    data={expenses}
    keyExtractor={(item) => item.id.toString()}
    renderItem={renderItem}
/>;
```

---

# 🚫 Avoid Inline Functions

---

## ❌ Bad Practice

```tsx id="bad1"
<FlatList renderItem={({ item }) => <ExpenseItem {...item} />} />
```

---

## ✅ Good Practice

```tsx id="good1"
const renderItem = ({ item }) => <ExpenseItem {...item} />;
```

---

👉 Avoid creating new functions inside render

---

# ⚡ Additional Optimization Strategies

---

## 🔹 Component Splitting

👉 Break large components into smaller ones

Example:

- ExpenseList
- ExpenseItem
- ExpenseHeader

---

## 🔹 Image Optimization

- Use compressed images
- Avoid large file sizes
- Lazy load images

---

## 🔹 Avoid Heavy State

- Keep state minimal
- Avoid storing unnecessary data

---

## 🔹 Batch Updates

👉 Combine state updates when possible

---

# 📊 Real ExpenseApp Optimization Scenario

---

## Problem

- Adding one expense causes full list re-render

---

## Solution

- Use React.memo for ExpenseItem
- Use useCallback for renderItem
- Use keyExtractor properly

---

## Result

👉 Only one item re-renders instead of entire list

---

# 🎯 When to Optimize

---

## Optimize When:

- Large datasets
- Performance issues visible
- Frequent UI updates

---

## Avoid Premature Optimization

👉 First make it work, then optimize

---

# ⚠️ Common Mistakes

- Overusing useMemo/useCallback
- Missing dependencies
- Using React.memo incorrectly
- Ignoring FlatList props
- Optimizing without measuring

---

# ✅ Best Practices

- Optimize lists first (biggest impact)
- Use memoization wisely
- Keep components simple
- Measure before optimizing
- Maintain readability

---

# 📘 Chapter Summary

In this chapter, you:

- Optimized FlatList using advanced props
- Prevented unnecessary re-renders
- Used React.memo effectively
- Applied useMemo and useCallback
- Improved ExpenseApp performance significantly
