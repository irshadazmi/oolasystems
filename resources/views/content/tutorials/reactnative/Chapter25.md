# Chapter 25: Testing Fundamentals (Jest & React Native Testing Library)

---

In previous chapters, we built several ExpenseApp features using:

- Navigation
- Context API
- AsyncStorage
- APIs
- Theme Context
- Expo Router
- Forms & Validation
- TypeScript

As applications grow larger, maintaining quality becomes more difficult.

Without proper testing:

❌ Bugs reach production

❌ Refactoring becomes risky

❌ Features break unexpectedly

❌ Debugging becomes difficult

Modern React Native applications solve these problems using:

✅ Automated Testing

In this chapter, we will learn testing fundamentals using:

✅ Jest

✅ React Native Testing Library (RNTL)

We will focus on testing real ExpenseApp components and user interactions.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand why testing matters
- Understand unit vs integration testing
- Configure Jest for React Native / Expo
- Use React Native Testing Library
- Use `render()` and `fireEvent()`
- Understand snapshot testing
- Understand behavior testing
- Test forms and interactions
- Write maintainable React Native tests

---

# ⚡ Why Testing Matters

Testing improves application reliability and maintainability.

Benefits:

✅ Catch bugs early

✅ Improve confidence during refactoring

✅ Improve code quality

✅ Reduce production issues

---

# 🔹 Real ExpenseApp Example

Imagine:

- Adding new transaction features
- Updating forms
- Refactoring navigation
- Changing API logic

Without testing:

❌ Existing features may break silently

With testing:

✅ Problems are detected early

---

# 🔹 Testing Philosophy

Modern testing focuses on:

✅ User behavior

instead of:

❌ Internal implementation details

We should test:

- What users see
- What users click
- What users type
- What happens after actions

---

# 🔹 Types of Testing

There are multiple testing types.

In this chapter, we focus on:

| Type                | Purpose             |
| ------------------- | ------------------- |
| Unit Testing        | Test isolated logic |
| Integration Testing | Test complete flows |

---

# 🧪 Unit Testing

Unit testing focuses on:

✅ Small functions

✅ Utility methods

✅ Individual components

---

# 🔹 Example

```ts id="test001"
const add = (a: number, b: number) => {
    return a + b;
};

test("adds numbers correctly", () => {
    expect(add(2, 3)).toBe(5);
});
```

---

# 🔹 Why Unit Testing Matters

Benefits:

✅ Fast execution

✅ Easier debugging

✅ Focused testing

---

# 🔗 Integration Testing

Integration testing verifies multiple parts working together.

---

# 🔹 ExpenseApp Example

Testing:

- Login form
- Transaction form
- Save button
- State updates
- UI rendering

all together.

---

# 🔹 Why Important?

Integration testing simulates real application behavior.

Benefits:

✅ More realistic testing

✅ Better user-flow validation

---

# 🔹 Unit vs Integration Testing

| Unit Test            | Integration Test        |
| -------------------- | ----------------------- |
| Tests isolated logic | Tests combined behavior |
| Faster               | Slightly slower         |
| Easier debugging     | More realistic          |

---

# ⚙️ What is Jest?

Jest is the default testing framework used by React Native.

It provides:

✅ Test runner

✅ Assertions

✅ Mocking utilities

✅ Snapshot support

---

# 🔹 Install Jest

Most Expo projects already include Jest.

If needed:

```bash id="jest001"
npm install --save-dev jest
```

---

# 🔹 Run Tests

```bash id="jest002"
npm test
```

---

# 🔹 Basic Jest Configuration

📁 `package.json`

```json id="jest003"
{
    "jest": {
        "preset": "react-native"
    }
}
```

---

# 🔹 Expo Projects

Expo projects already include Jest setup.

Usually you only need:

```bash id="jest004"
npm test
```

---

# ⚛️ React Native Testing Library (RNTL)

---

# 🔹 What is RNTL?

React Native Testing Library helps test components from the user’s perspective.

---

# 🔹 Install RNTL

```bash id="rntl001"
npm install --save-dev @testing-library/react-native
```

---

# 🔹 Core Philosophy

Test:

✅ What users see

✅ What users do

Avoid testing:

❌ Internal React state

❌ Implementation details

---

# 🔹 render()

`render()` creates component UI inside a test environment.

---

# 🔹 Basic Example

```tsx id="rntl002"
import { render } from "@testing-library/react-native";

import { Text } from "react-native";

test("renders text", () => {
    const { getByText } = render(<Text>Hello</Text>);

    expect(getByText("Hello")).toBeTruthy();
});
```

---

# 🔹 What getByText() Does

```tsx id="rntl003"
getByText("Hello");
```

searches rendered UI exactly like users see text on screen.

---

# 🔥 fireEvent()

`fireEvent()` simulates user interactions.

---

# 🔹 Example

```tsx id="rntl004"
import { render, fireEvent } from "@testing-library/react-native";

import { Pressable, Text } from "react-native";

test("button click works", () => {
    const onPress = jest.fn();

    const { getByText } = render(
        <Pressable onPress={onPress}>
            <Text>Save</Text>
        </Pressable>,
    );

    fireEvent.press(getByText("Save"));

    expect(onPress).toHaveBeenCalled();
});
```

---

# 🔹 Why fireEvent Matters

It helps simulate:

✅ Button presses

✅ Text input

✅ Form submission

✅ User interactions

---

# 🧪 ExpenseApp Component Test

📁 `src/components/expense-item.test.tsx`

---

# 🔹 ExpenseItem Test

```tsx id="exp001"
test("renders expense item correctly", () => {
    const { getByText } = render(<ExpenseItem title="Food" amount={200} />);

    expect(getByText("Food")).toBeTruthy();

    expect(getByText("₹200")).toBeTruthy();
});
```

---

# 🔹 What This Tests

✅ Title rendering

✅ Amount rendering

✅ UI visibility

---

# 🧪 Transaction Form Test

📁 `src/components/transaction-form.test.tsx`

---

# 🔹 Example

```tsx id="trx001"
test("updates description input", () => {
    const { getByPlaceholderText } = render(<TransactionForm />);

    const input = getByPlaceholderText("Description");

    fireEvent.changeText(input, "Food Expense");

    expect(input.props.value).toBe("Food Expense");
});
```

---

# 🔗 ExpenseApp Integration Test

📁 `src/app/add-transaction.test.tsx`

---

# 🔹 Example

```tsx id="exp002"
test("adds new transaction", () => {
    const { getByPlaceholderText, getByText } = render(<AddTransaction />);

    fireEvent.changeText(getByPlaceholderText("Description"), "Food");

    fireEvent.changeText(getByPlaceholderText("Amount"), "200");

    fireEvent.press(getByText("Save Transaction"));

    expect(getByText("Food")).toBeTruthy();
});
```

---

# 🔹 Why Integration Testing Matters

This tests:

✅ Inputs

✅ Button click

✅ State updates

✅ UI rendering

all together.

---

# 📸 Snapshot Testing

Snapshot testing captures component UI structure.

Future test runs compare against stored snapshots.

---

# 🔹 Example

```tsx id="snap001"
test("matches snapshot", () => {
    const tree = render(<ExpenseItem title="Food" amount={200} />).toJSON();

    expect(tree).toMatchSnapshot();
});
```

---

# 🔹 Snapshot Benefits

✅ Detects UI changes quickly

✅ Easy to create

---

# 🔹 Snapshot Problems

❌ Can become outdated

❌ Does not test user behavior

❌ Easy to misuse

---

# 🎯 Behavior Testing (Preferred)

Modern testing prefers behavior testing.

---

# 🔹 What is Behavior Testing?

Tests how users interact with the application.

---

# 🔹 Example

```tsx id="beh001"
expect(getByText("Food")).toBeTruthy();
```

---

# 🔹 Why Better?

Benefits:

✅ More realistic

✅ Less fragile

✅ Better long-term maintainability

---

# 🔹 Async Testing

Many React Native features are asynchronous.

Examples:

- API calls
- AsyncStorage
- Navigation
- Authentication

---

# 🔹 Example

```tsx id="async001"
await waitFor(() => {
    expect(getByText("Success")).toBeTruthy();
});
```

---

# 🔹 Why Important?

Without proper async handling:

❌ Tests fail unpredictably

---

# 🔹 Mocking

Mocking simulates external dependencies.

---

# 🔹 Why Mocking Matters

Applications often depend on:

- APIs
- AsyncStorage
- Navigation
- Device APIs

Mocking isolates tests safely.

---

# 🔹 Basic Mock Example

```ts id="mock001"
const mockSave = jest.fn();
```

---

# 🔹 API Mock Example

```ts id="mock002"
global.fetch = jest.fn();
```

---

# 🔹 Common Mock Targets

| Dependency    | Why Mock                |
| ------------- | ----------------------- |
| API calls     | Avoid real requests     |
| Navigation    | Simplify tests          |
| AsyncStorage  | Avoid device dependency |
| Notifications | Avoid native behavior   |

---

# 🔹 Recommended Test Folder Structure

```text id="folder001"
src
│
├── app
│   ├── add-transaction.tsx
│   └── add-transaction.test.tsx
│
├── components
│   ├── expense-item.tsx
│   └── expense-item.test.tsx
│
├── services
│   ├── transaction-service.ts
│   └── transaction-service.test.ts
│
└── __mocks__
```

---

# ⚡ Performance Considerations

Good tests should be:

✅ Fast

✅ Independent

✅ Simple

Avoid:

❌ Heavy setup

❌ Real network calls

❌ Large complex tests

---

# 🔹 What NOT to Test

Avoid testing:

❌ Internal React state directly

❌ Library internals

❌ Implementation details

Focus on:

✅ User behavior
✅ Outputs
✅ Screen behavior

---

# ⚠️ Common Mistakes

❌ Overusing snapshot tests
❌ Testing implementation details
❌ Writing huge tests
❌ Not mocking dependencies
❌ Forgetting async handling

---

# ✅ Best Practices

✅ Test user behavior
✅ Keep tests small and focused
✅ Use RNTL for UI testing
✅ Mock external dependencies
✅ Prefer integration testing for UI flows
✅ Keep tests near components

---

# 🧪 Practice Exercises

1. Test Login screen
2. Test TransactionForm validation
3. Add snapshot test for ExpenseItem
4. Mock API request
5. Mock AsyncStorage
6. Test theme toggle behavior
7. Test transaction creation flow

---

# 📘 Chapter Summary

In this chapter, you:

✅ Learned why testing matters
✅ Understood unit vs integration testing
✅ Configured Jest for React Native
✅ Used React Native Testing Library
✅ Rendered components using render()
✅ Simulated user interactions using fireEvent()
✅ Tested ExpenseApp forms and components
✅ Understood snapshot vs behavior testing
✅ Built reliable React Native testing workflows
