# Chapter 28: Build & Deployment with Expo (EAS)

---

In previous chapters, we built several ExpenseApp features using:

- Navigation
- Context API
- AsyncStorage
- APIs
- Notifications
- Forms & Validation
- Expo Router
- TypeScript
- Testing
- Debugging
- Refactoring

So far, ExpenseApp has been running in:

✅ Development Mode

using:

```bash id="dev001"
npx expo start
```

Now we will prepare the application for:

✅ Production Build

✅ APK/AAB Generation

✅ Play Store Deployment

In this chapter, we will learn how to build and deploy React Native applications using:

✅ Expo Application Services (EAS)

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Configure app branding
- Configure app icons and splash screen
- Understand `app.json` and `app.config.js`
- Use environment variables securely
- Build APK/AAB using Expo EAS
- Understand signing basics
- Prepare Play Store release assets
- Follow production deployment workflow

---

# ⚡ Development vs Production Build

During development:

✅ Fast refresh

✅ Debugging tools

✅ Development server

are enabled.

Production builds are different.

---

# 🔹 Production Build Goals

Production builds should be:

✅ Optimized

✅ Stable

✅ Secure

✅ Release-ready

---

# 🔹 Real ExpenseApp Example

Production build allows users to:

✅ Install ExpenseApp from Play Store

✅ Use app without Expo server

✅ Receive updates

---

# 🎨 App Branding

App branding defines visual identity.

---

# 🔹 Why Branding Matters

Good branding improves:

✅ Professional appearance

✅ User trust

✅ App recognition

---

# 🖼️ App Icon

The app icon appears on:

✅ Home screen

✅ Play Store

✅ Installed applications list

---

# 🔹 Recommended Icon Size

Recommended:

```text id="brand001"
1024 × 1024 PNG
```

---

# 🔹 Configure Icon

📁 `app.json`

```json id="icon001"
{
    "expo": {
        "icon": "./assets/icon.png"
    }
}
```

---

# 🔹 Best Practices

✅ Keep icon simple

✅ Avoid too much text

✅ Use clean branding

---

# 🚀 Splash Screen

Splash screen appears while app loads.

---

# 🔹 Why Important?

Provides:

✅ Better first impression

✅ Smoother startup experience

---

# 🔹 Configure Splash Screen

📁 `app.json`

```json id="splash001"
{
    "expo": {
        "splash": {
            "image": "./assets/splash.png",
            "resizeMode": "contain",
            "backgroundColor": "#ffffff"
        }
    }
}
```

---

# 🔹 Splash Screen Tips

✅ Keep design minimal

✅ Use centered logo

✅ Match application theme

---

# ⚙️ Understanding app.json

`app.json` is the main Expo configuration file.

---

# 🔹 Why Important?

It controls:

✅ App name

✅ Version

✅ Icon

✅ Splash screen

✅ Package configuration

---

# 🔹 Example app.json

📁 `app.json`

```json id="app001"
{
    "expo": {
        "name": "ExpenseApp",

        "slug": "expense-app",

        "version": "1.0.0",

        "orientation": "portrait",

        "platforms": ["android", "ios"]
    }
}
```

---

# 🔹 Important Fields

| Field     | Purpose                        |
| --------- | ------------------------------ |
| name      | Application name               |
| slug      | Unique Expo project identifier |
| version   | App version                    |
| platforms | Supported platforms            |

---

# 🔹 Android Package Name

Production Android apps require unique package names.

---

# 🔹 Example

```json id="app002"
{
    "expo": {
        "android": {
            "package": "com.expenseapp.mobile"
        }
    }
}
```

---

# 🔹 Why Important?

Package name uniquely identifies your application on Play Store.

---

# 🧩 app.config.js

Advanced applications often use:

```text id="config001"
app.config.js
```

instead of `app.json`.

---

# 🔹 Why Use app.config.js?

Benefits:

✅ Dynamic configuration

✅ Environment-based configuration

✅ Better flexibility

---

# 🔹 Example

📁 `app.config.js`

```js id="config002"
export default {
    expo: {
        name: "ExpenseApp",
        version: "1.0.0",
    },
};
```

---

# 🔹 ExpenseApp Use Case

Useful for:

✅ Development URLs

✅ Production URLs

✅ Environment-specific values

---

# 🔐 Environment Variables

Environment variables help manage configuration safely.

---

# 🔹 Why Needed?

Applications often require:

✅ API URLs

✅ Firebase keys

✅ Environment configs

---

# 🔹 Example .env File

📁 `.env`

```env id="env001"
API_URL=https://api.expenseapp.com
```

---

# 🔹 Why NOT Hardcode?

Hardcoding causes:

❌ Security risks

❌ Difficult deployments

❌ Environment confusion

---

# 🔹 Access Environment Variable

```ts id="env002"
process.env.API_URL;
```

---

# 🔹 Expo Environment Setup

Expo commonly uses:

```bash id="env003"
npm install dotenv
```

---

# 🔹 Recommended Setup

Different environments:

| Environment | Purpose          |
| ----------- | ---------------- |
| Development | Local testing    |
| Staging     | QA/testing       |
| Production  | Live application |

---

# 📦 Expo Application Services (EAS)

---

# 🔹 What is EAS?

EAS stands for:

```text id="eas001"
Expo Application Services
```

It provides:

✅ Cloud builds

✅ App signing

✅ Deployment tools

---

# 🔹 Why EAS?

Benefits:

✅ Simpler deployment

✅ Cloud-based builds

✅ Easier signing management

---

# 🔹 Install EAS CLI

```bash id="eas002"
npm install -g eas-cli
```

---

# 🔹 Login to Expo

```bash id="eas003"
eas login
```

---

# 🔹 Configure EAS

```bash id="eas004"
eas build:configure
```

This creates:

📁 `eas.json`

---

# 🔹 Example eas.json

```json id="eas005"
{
    "build": {
        "production": {
            "android": {
                "buildType": "app-bundle"
            }
        }
    }
}
```

---

# 📱 APK vs AAB

---

# 🔹 APK

APK is used for:

✅ Local installation

✅ Internal testing

---

# 🔹 AAB

AAB (Android App Bundle) is used for:

✅ Google Play Store

---

# 🔹 Recommendation

| File | Use Case           |
| ---- | ------------------ |
| APK  | Testing            |
| AAB  | Production release |

---

# 🔹 Build Android App

```bash id="eas006"
eas build -p android
```

---

# 🔹 Build iOS App

```bash id="eas007"
eas build -p ios
```

---

# 🔹 ExpenseApp Example

Build production Android release:

```bash id="eas008"
eas build -p android --profile production
```

---

# 🔑 App Signing Basics

Android applications require signing.

---

# 🔹 Why Signing Matters

Signing ensures:

✅ App authenticity

✅ Secure updates

✅ Trusted installations

---

# 🔹 Types of Signing

| Type            | Purpose     |
| --------------- | ----------- |
| Debug Signing   | Development |
| Release Signing | Production  |

---

# 🔹 Expo Simplification

Expo can manage signing automatically.

---

# 🔹 Important Note

Always keep signing keys safe.

Without them:

❌ Future app updates become difficult

---

# 📲 Google Play Store Preparation

Before uploading application:

✅ Test thoroughly

✅ Verify APIs

✅ Verify themes

✅ Check performance

---

# 🔹 Required Store Assets

Play Store requires:

✅ App icon

✅ Screenshots

✅ Feature graphic

✅ App description

✅ Privacy policy

---

# 🔹 Important App Information

| Item         | Example               |
| ------------ | --------------------- |
| Version      | 1.0.0                 |
| Package Name | com.expenseapp.mobile |
| Category     | Finance               |

---

# 🔹 Real Device Testing

Always test on:

✅ Physical Android devices

✅ Different screen sizes

✅ Different Android versions

---

# 🔹 What to Verify

Before release:

✅ Login flow

✅ Transactions

✅ APIs

✅ Notifications

✅ Dark mode

✅ Navigation

---

# 🚀 Play Store Upload Workflow

---

# 🔹 Step 1

Create:

```text id="play001"
Google Play Console Account
```

---

# 🔹 Step 2

Generate production AAB:

```bash id="play002"
eas build -p android
```

---

# 🔹 Step 3

Download generated AAB.

---

# 🔹 Step 4

Upload AAB to Play Console.

---

# 🔹 Step 5

Fill:

✅ Store listing

✅ Screenshots

✅ Descriptions

✅ Privacy policy

---

# 🔹 Step 6

Submit for review.

---

# 🧪 ExpenseApp Deployment Example

---

# 🔹 Build Production App

```bash id="deploy001"
eas build -p android
```

---

# 🔹 Download Build

Expo provides downloadable build link.

---

# 🔹 Install & Verify

Install APK on device and verify:

✅ Login
✅ Transactions
✅ API connectivity
✅ Notifications

---

# ⚡ Release Best Practices

✅ Use environment variables
✅ Increment app versions properly
✅ Keep builds reproducible
✅ Store signing keys securely
✅ Test thoroughly before release

---

# ⚠️ Common Mistakes

❌ Wrong production API URL
❌ Missing splash/icon assets
❌ Losing signing keys
❌ Releasing without testing
❌ Incorrect package name
❌ Using debug configurations in production

---

# 🔹 Recommended Production Workflow

```text id="workflow001"
Develop Feature
      ↓
Test Thoroughly
      ↓
Create Production Build
      ↓
Verify APK/AAB
      ↓
Upload to Play Store
      ↓
Monitor Release
```

---

# 🧪 Practice Exercises

1. Configure custom app icon
2. Configure splash screen
3. Add environment variables
4. Create production EAS build
5. Generate APK for testing
6. Generate AAB for Play Store
7. Prepare Play Store screenshots

---

# 📘 Chapter Summary

In this chapter, you:

✅ Configured app branding
✅ Configured icons and splash screens
✅ Understood app.json and app.config.js
✅ Used environment variables
✅ Built APK/AAB using Expo EAS
✅ Learned signing basics
✅ Prepared Play Store deployment workflow
✅ Built production-ready ExpenseApp releases
