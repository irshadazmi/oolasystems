# Chapter 14: API Integration, Async Operations & Error Handling

---

In previous chapters, we stored data locally using Context API and AsyncStorage.

However, real-world applications usually communicate with backend servers.

Examples:

- Uber fetches ride information from APIs
- Instagram loads posts from backend servers
- Banking apps fetch account balances from secure APIs

Similarly, ExpenseApp should also be able to:

- Fetch expenses from server
- Add new expenses
- Update existing expenses
- Delete expenses
- Handle loading and network failures

In this chapter, we learn how to integrate APIs into our React Native application using:

✅ Fetch API
✅ Axios
✅ Async programming
✅ Loading states
✅ Error handling
✅ Service layer architecture

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand REST APIs
- Learn client-server architecture
- Perform CRUD operations
- Use Fetch and Axios
- Work with mock APIs
- Handle loading and error states
- Use async/await
- Implement try/catch/finally
- Create reusable API service layers
- Structure scalable networking code

---

# 🌐 Why APIs are Important

Modern mobile applications rarely store all data inside the app itself.

Instead, applications communicate with backend servers.

APIs help applications:

- Fetch data
- Save records
- Update information
- Authenticate users
- Sync data across devices

---

# 🔹 Client-Server Architecture

```text id="zx8e1n"
React Native App
        ↓
REST API Server
        ↓
Database
```

👉 The mobile app communicates with backend APIs using HTTP requests.

---

# 🔹 What is a REST API?

REST (Representational State Transfer) is a standard way for applications to communicate over the internet.

REST APIs use HTTP methods to perform operations on data.

---

# 🔹 Common HTTP Methods

| Method | Purpose     | ExpenseApp Example |
| ------ | ----------- | ------------------ |
| GET    | Fetch data  | Get all expenses   |
| POST   | Create data | Add expense        |
| PUT    | Update data | Update expense     |
| DELETE | Remove data | Delete expense     |

---

# 🔹 Example API Endpoint

```text id="pk9x5r"
https://api.expenseapp.com/expenses
```

---

# 🔹 What is JSON?

JSON (JavaScript Object Notation) is the standard format used for exchanging data between applications and servers.

---

## Example JSON

```json id="vqqjmu"
{
  "id": 1,
  "description": "Food",
  "amount": 250
}
```

---

## JSON Characteristics

- Lightweight
- Human-readable
- Easy to parse
- Widely used in APIs

---

# 🔄 CRUD Operations

CRUD stands for:

| Operation | Meaning     |
| --------- | ----------- |
| Create    | Add data    |
| Read      | Fetch data  |
| Update    | Modify data |
| Delete    | Remove data |

---

# 🔹 GET Request (Fetch Data)

```tsx id="1azn9q"
const fetchExpenses = async () => {
  try {
    const response = await fetch("https://api.example.com/expenses");

    const data = await response.json();

    console.log(data);
  } catch (error) {
    console.log(error);
  }
};
```

👉 Retrieves expense data from server

---

# 🔹 POST Request (Create Data)

```tsx id="83zj2l"
await fetch("https://api.example.com/expenses", {
  method: "POST",

  headers: {
    "Content-Type": "application/json",
  },

  body: JSON.stringify({
    description: "Food",
    amount: 250,
  }),
});
```

👉 Adds new expense to server

---

# 🔹 PUT Request (Update Data)

```tsx id="5j0g7m"
await fetch("https://api.example.com/expenses/1", {
  method: "PUT",

  headers: {
    "Content-Type": "application/json",
  },

  body: JSON.stringify({
    amount: 500,
  }),
});
```

👉 Updates existing expense

---

# 🔹 DELETE Request

```tsx id="x6e6nt"
await fetch("https://api.example.com/expenses/1", {
  method: "DELETE",
});
```

👉 Deletes expense from server

---

# 🔹 Understanding async/await

API calls take time because data travels over the internet.

JavaScript handles this using asynchronous programming.

`async/await` makes asynchronous code easier to understand.

---

## Benefits of async/await

✅ Cleaner code
✅ Easier debugging
✅ Better readability
✅ Simpler error handling

---

# ⚖️ Fetch vs Axios

---

# 🔹 Fetch API

Fetch is built into JavaScript.

---

## Example

```tsx id="jcn1vx"
const response = await fetch(url);

const data = await response.json();
```

---

## Advantages

✅ Built-in
✅ No installation required

---

## Disadvantages

❌ More boilerplate
❌ Manual JSON parsing
❌ Manual error handling

---

# 🔹 Axios

Axios is a popular HTTP library.

---

## Install Axios

```bash id="k9c2m5"
npx expo install axios
```

---

## Example

```tsx id="avqfh0"
import axios from "axios";

const response = await axios.get("https://api.example.com/expenses");

console.log(response.data);
```

---

# 🔹 Advantages of Axios

✅ Automatic JSON parsing
✅ Better error handling
✅ Request/response interceptors
✅ Cleaner syntax
✅ Timeout support

👉 Axios is preferred in real-world applications.

---

# 🧪 Calling Mock APIs

Mock APIs help developers test applications without creating real backend servers.

---

# 🔹 Popular Mock APIs

- JSONPlaceholder
- ReqRes
- MockAPI
- Local Express Server

---

# 🔹 Example Mock API Request

```tsx id="8qg0m5"
const fetchPosts = async () => {
  try {
    const response = await axios.get(
      "https://jsonplaceholder.typicode.com/posts",
    );

    console.log(response.data);
  } catch (error) {
    console.log(error);
  }
};
```

---

# ⏳ Handling Loading State

API requests take time.

Applications should inform users while data is loading.

---

# 🔹 Loading State Example

```tsx id="2r79oz"
const [loading, setLoading] = useState(false);

const [expenses, setExpenses] = useState([]);

const fetchExpenses = async () => {
  try {
    setLoading(true);

    const response = await axios.get("/expenses");

    setExpenses(response.data);
  } catch (error) {
    console.log(error);
  } finally {
    setLoading(false);
  }
};
```

---

# 🔹 Loading UI

```tsx id="8f2v0v"
{
  loading && <Text>Loading...</Text>;
}
```

---

👉 Improves user experience

---

# ❌ Handling Error State

Network requests can fail because of:

- No internet
- Server errors
- Invalid API endpoints
- Timeout issues

Applications should handle errors gracefully.

---

# 🔹 Error State Example

```tsx id="88rf6x"
const [error, setError] = useState<string | null>(null);
```

---

# 🔹 Error Handling

```tsx id="2rjvn7"
try {
  const response = await axios.get("/expenses");

  setExpenses(response.data);
} catch (error) {
  setError("Unable to load expenses");
}
```

---

# 🔹 Error UI

```tsx id="wkvq6f"
{
  error && (
    <Text
      style={{
        color: "red",
      }}
    >
      {error}
    </Text>
  );
}
```

---

# 🛡️ try/catch/finally

---

# 🔹 Why Important?

`try/catch` prevents applications from crashing during API failures.

`finally` always runs whether request succeeds or fails.

---

# 🔹 Example

```tsx id="q8s4jz"
try {
  setLoading(true);

  const response = await axios.get("/expenses");

  setExpenses(response.data);
} catch (error) {
  setError("Failed to fetch expenses");
} finally {
  setLoading(false);
}
```

---

# 🔹 Common HTTP Status Codes

| Code | Meaning      |
| ---- | ------------ |
| 200  | Success      |
| 201  | Created      |
| 400  | Bad Request  |
| 401  | Unauthorized |
| 404  | Not Found    |
| 500  | Server Error |

---

# ⏱️ Handling Timeouts

Timeouts prevent applications from waiting forever for server responses.

---

# 🔹 Axios Timeout

```tsx id="w2d4zq"
axios.get("/expenses", {
  timeout: 5000,
});
```

👉 Request fails after 5 seconds

---

# 🔹 Fetch Timeout using AbortController

```tsx id="0dsk2e"
const controller = new AbortController();

setTimeout(() => controller.abort(), 5000);

fetch(url, {
  signal: controller.signal,
});
```

---

# 🔹 API Service Layer

Real-world applications separate API logic from UI components.

This improves:

✅ Reusability
✅ Maintainability
✅ Scalability

---

# 🔹 Create Axios Instance

📁 `src/services/api.ts`

```tsx id="f0yoj8"
import axios from "axios";

const api = axios.create({
  baseURL: "https://api.example.com",

  timeout: 5000,
});

export default api;
```

---

# 🔹 Create Expense Service

📁 `src/services/expenseService.ts`

```tsx id="3dhk9h"
import api from "./api";

export type Expense = {
  id: number;
  description: string;
  amount: number;
};

export const getExpenses = async (): Promise<Expense[]> => {
  const response = await api.get("/expenses");

  return response.data;
};

export const createExpense = async (expense: Expense) => {
  return api.post("/expenses", expense);
};

export const deleteExpense = async (id: number) => {
  return api.delete(`/expenses/${id}`);
};
```

---

# 🧪 ExpenseApp Full API Example

📁 `src/app/index.tsx`

```tsx id="k4n8ml"
import React, { useEffect, useState } from "react";

import {
  ActivityIndicator,
  FlatList,
  SafeAreaView,
  Text,
  View,
} from "react-native";

import { Expense, getExpenses } from "../services/expenseService";

export default function HomeScreen() {
  const [expenses, setExpenses] = useState<Expense[]>([]);

  const [loading, setLoading] = useState(false);

  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    fetchExpenses();
  }, []);

  const fetchExpenses = async () => {
    try {
      setLoading(true);

      const data = await getExpenses();

      setExpenses(data);
    } catch (error) {
      setError("Failed to load expenses");
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return <ActivityIndicator />;
  }

  if (error) {
    return <Text>{error}</Text>;
  }

  return (
    <SafeAreaView>
      <FlatList
        data={expenses}
        keyExtractor={(item) => item.id.toString()}
        renderItem={({ item }) => (
          <View
            style={{
              padding: 15,
              borderBottomWidth: 1,
            }}
          >
            <Text>{item.description}</Text>

            <Text>₹{item.amount}</Text>
          </View>
        )}
      />
    </SafeAreaView>
  );
}
```

---

# 🔹 Recommended Folder Structure

```text id="km0t4f"
src
│
├── app
│   └── index.tsx
│
├── services
│   ├── api.ts
│   └── expenseService.ts
│
├── contexts
│   └── ExpenseContext.tsx
│
├── hooks
│   └── useExpenseContext.ts
│
├── components
│   └── ExpenseItem.tsx
│
└── styles
    └── styles.ts
```

---

# ✅ Best Practices

✅ Keep API logic separate from UI

✅ Use reusable service files

✅ Always handle loading states

✅ Always handle errors

✅ Use TypeScript types

✅ Use async/await

✅ Use try/catch/finally

✅ Use request timeouts

✅ Keep components focused

---

# ⚠️ Common Mistakes

❌ Ignoring loading states
❌ Ignoring API failures
❌ Forgetting async/await
❌ Writing API calls directly inside JSX
❌ Using `any` type everywhere
❌ Mixing networking logic with UI
❌ Forgetting timeout handling

---

# 🧪 Practice Exercises

1. Add Update Expense API
2. Add Delete Expense API
3. Add Retry button on error
4. Add Pull-to-Refresh functionality
5. Create reusable Loading component
6. Add API timeout handling
7. Create Auth API service

---

# 📘 Chapter Summary

In this chapter, you:

✅ Learned REST API fundamentals

✅ Understood client-server architecture

✅ Performed CRUD operations

✅ Used Fetch and Axios

✅ Worked with mock APIs

✅ Handled loading states

✅ Implemented robust error handling

✅ Used async/await and try/catch

✅ Created reusable API service layers

✅ Built scalable networking architecture
