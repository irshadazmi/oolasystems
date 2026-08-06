# Chapter 1: Web, HTML, CSS & JavaScript Fundamentals

---

# Introduction

Before learning React Native, it is important to understand some basic web development concepts.

React Native applications are mainly built using:

- JavaScript
- React concepts
- Components
- Layouts
- Styling
- Events
- State management

Even though React Native does not directly use HTML and CSS like web applications, many concepts come from web development.

This chapter introduces the minimum fundamentals required before starting React Native.

---

# What You Will Learn

By the end of this chapter, you will:

- Understand how web applications work
- Learn HTML basics
- Learn CSS fundamentals
- Understand JavaScript essentials
- Understand React concepts
- See how web concepts map to React Native

---

# Understanding Web Applications

A web application is software that runs inside a web browser.

Examples:

- Gmail
- YouTube
- Facebook
- Amazon
- Banking portals

Modern web applications mainly use:

| Technology | Purpose                 |
| ---------- | ----------------------- |
| HTML       | Structure               |
| CSS        | Styling                 |
| JavaScript | Logic and interactivity |

---

# Web Application Architecture

Modern applications follow a client-server architecture.

In this architecture:

- Clients send requests
- Servers process requests
- Data is exchanged through the Internet

Clients can be:

- Mobile applications
- Web browsers
- Desktop applications

Servers handle:

- Business logic
- Database operations
- Authentication
- APIs
- File storage

---

# Web Application Architecture Diagram

![Web Application Architecture](/images/tutorials/reactnative/webapp-architecture.png)

---

# Understanding the Architecture Flow

```text
Client → Internet → Server → Database
```

---

# Components of Web Application Architecture

| Component          | Purpose                             |
| ------------------ | ----------------------------------- |
| Client             | User interface and user interaction |
| Internet           | Communication medium                |
| Application Server | Business logic processing           |
| Database           | Data storage                        |
| Cache              | Faster data access                  |
| External Services  | Third-party integrations            |

---

# Request & Response Flow

1. User performs an action on the client application
2. Request travels through the Internet
3. Server processes the request
4. Database retrieves or stores data
5. Response returns back to the client

---

# Real-world Example

When a user adds an expense in ExpenseApp:

1. Mobile app sends expense data
2. Server validates and processes data
3. Database stores expense information
4. Server sends success response
5. App updates the UI

# Frontend vs Backend

Applications are usually divided into two parts.

## Frontend

Frontend is the user interface visible to users.

Examples:

- Buttons
- Forms
- Images
- Menus
- Lists

Common frontend technologies:

- HTML
- CSS
- JavaScript
- React
- React Native

---

## Backend

Backend handles:

- Business logic
- Authentication
- Database operations
- APIs
- Server-side processing

Common backend technologies:

- Node.js
- Java
- .NET
- PHP
- Python

---

# What is HTML?

HTML stands for:

```text
HyperText Markup Language
```

HTML defines the structure of a web page.

---

# Basic HTML Example

```html
<!DOCTYPE html>
<html>
  <head>
    <title>My First Page</title>
  </head>

  <body>
    <h1>Hello World</h1>
    <p>Welcome to HTML</p>
  </body>
</html>
```

---

# HTML Tags

HTML uses tags to create elements.

Example:

```html
<h1>Hello</h1>
```

Here:

- `<h1>` is the opening tag
- `</h1>` is the closing tag

---

# Common HTML Tags

| Tag        | Purpose     |
| ---------- | ----------- |
| `<h1>`     | Heading     |
| `<p>`      | Paragraph   |
| `<img>`    | Image       |
| `<button>` | Button      |
| `<input>`  | Input field |
| `<div>`    | Container   |
| `<a>`      | Link        |

---

# Heading Example

```html
<h1>Main Heading</h1>
<h2>Sub Heading</h2>
<h3>Small Heading</h3>
```

---

# Paragraph Example

```html
<p>This is a paragraph.</p>
```

---

# Button Example

```html
<button>Save</button>
```

---

# Input Field Example

```html
<input type="text" placeholder="Enter name" />
```

---

# Image Example

```html
<img src="logo.png" width="100" />
```

---

# Link Example

```html
<a href="https://google.com">Open Google</a>
```

---

# Div Container Example

```html
<div>
  <h1>Expense App</h1>
  <p>Add your expenses</p>
</div>
```

---

# HTML Page Structure

| Section | Purpose         |
| ------- | --------------- |
| `html`  | Root element    |
| `head`  | Metadata        |
| `title` | Browser title   |
| `body`  | Visible content |

---

# What is CSS?

CSS stands for:

```text
Cascading Style Sheets
```

CSS is used for:

- Colors
- Layouts
- Fonts
- Borders
- Spacing
- Alignment

---

# CSS Syntax

```css
selector {
  property: value;
}
```

---

# CSS Example

```css
h1 {
  color: blue;
  font-size: 24px;
}
```

---

# Common CSS Properties

| Property         | Purpose          |
| ---------------- | ---------------- |
| color            | Text color       |
| background-color | Background color |
| font-size        | Text size        |
| margin           | Outer spacing    |
| padding          | Inner spacing    |
| border           | Border           |
| width            | Width            |
| height           | Height           |

---

# Colors

```css
color: red;
background-color: yellow;
```

---

# Font Size

```css
font-size: 20px;
```

---

# Margin and Padding

```css
margin: 20px;
padding: 20px;
```

- Margin adds outer spacing
- Padding adds inner spacing

---

# Border Example

```css
border: 1px solid black;
```

---

# CSS Classes

```html
<h1 class="title">Expense App</h1>
```

```css
.title {
  color: blue;
}
```

---

# CSS IDs

```html
<h1 id="main-title">Expense App</h1>
```

```css
#main-title {
  color: green;
}
```

---

Yes, I agree.

Since **Flexbox is covered in detail later (Chapter 5)**, introducing it in Chapter 1 creates:

- Unnecessary duplication
- Early exposure to concepts students are not ready for yet
- A break in the learning progression

In Chapter 1, it is better to introduce the **CSS Box Model**, because it directly relates to:

- Margin
- Padding
- Border
- Width
- Height

which you already discuss in that section.

---

## Replace This Section

### ❌ Remove

````md
# Flexbox Layout

Modern applications use Flexbox for layouts.

React Native also uses Flexbox.

---

# Flexbox Example

```css
.container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
```
````

````

---

# CSS Box Model

Every HTML element is displayed as a rectangular box.

The CSS Box Model defines how space is calculated around an element.

It consists of four parts:

1. Content
2. Padding
3. Border
4. Margin

---

# CSS Box Model Diagram

```text
┌─────────────────────────────┐
│           Margin            │
│  ┌───────────────────────┐  │
│  │        Border         │  │
│  │  ┌─────────────────┐  │  │
│  │  │     Padding     │  │  │
│  │  │ ┌─────────────┐ │  │  │
│  │  │ │   Content   │ │  │  │
│  │  │ └─────────────┘ │  │  │
│  │  └─────────────────┘  │  │
│  └───────────────────────┘  │
└─────────────────────────────┘
````

---

# Understanding Each Part

| Part    | Purpose                                |
| ------- | -------------------------------------- |
| Content | Actual text, image, or element content |
| Padding | Space between content and border       |
| Border  | Visible boundary around the element    |
| Margin  | Space outside the border               |

---

# Example

```css
.card {
  width: 200px;
  padding: 20px;
  border: 1px solid black;
  margin: 20px;
}
```

---

# What is JavaScript?

JavaScript is the programming language of the web.

It adds:

- Logic
- Interactivity
- Calculations
- Dynamic behavior
- Event handling

React Native applications are mainly written using JavaScript.

---

# JavaScript Example

```js
console.log("Hello World");
```

---

# Variables

Variables store data.

## Using let

```js
let amount = 500;
```

## Using const

```js
const category = "Food";
```

---

# Data Types

JavaScript supports multiple data types.

## String

```js
const name = "Irshad";
```

## Number

```js
const amount = 500;
```

## Boolean

```js
const isPaid = true;
```

## Array

```js
const categories = ["Food", "Travel"];
```

## Object

```js
const expense = {
  title: "Food",
  amount: 200,
};
```

---

# Functions

Functions perform reusable tasks.

```js
function add(a, b) {
  return a + b;
}
```

---

# Conditions

Conditions control application flow.

```js
if (amount > 1000) {
  console.log("High Expense");
} else {
  console.log("Normal Expense");
}
```

---

# Loops

Loops repeat tasks.

```js
for (let i = 0; i < 5; i++) {
  console.log(i);
}
```

---

# Arrays and Objects

Arrays and objects are widely used in JavaScript.

## Array Example

```js
const expenses = [
  {
    id: 1,
    title: "Food",
    amount: 200,
  },
  {
    id: 2,
    title: "Travel",
    amount: 500,
  },
];
```

## Object Example

```js
const user = {
  name: "Irshad",
  city: "Pune",
};
```

## Accessing Object Properties

```js
console.log(user.name);
```

---

# Events

Events respond to user actions.

Examples:

- Button click
- Typing
- Screen touch

---

# HTML Event Example

```html
<button onclick="saveExpense()">Save</button>
```

---

# Introduction to React

React is a JavaScript library used to build user interfaces.

React introduced:

- Components
- Props
- State
- Declarative UI

React Native is based on React concepts.

---

# Components

Components are reusable UI blocks.

```tsx
function Header() {
  return <Text>Expense App</Text>;
}
```

---

# JSX Example

```tsx
<View>
  <Text>Hello</Text>
</View>
```

---

# Why Learn Web Basics Before React Native?

React Native becomes easier when students already understand:

- HTML structure
- CSS layouts
- JavaScript logic
- Functions
- Events
- Components

---

# Key Takeaways

- HTML provides structure
- CSS provides styling
- JavaScript provides logic
- React provides reusable components
- React Native uses React concepts for mobile applications

---

# Chapter Summary

In this chapter, you:

- Understood how web applications work
- Learned HTML basics
- Learned CSS fundamentals
- Learned JavaScript essentials
- Understood React concepts
- Learned how web concepts relate to React Native
