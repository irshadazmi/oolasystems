# Chapter 17: Device APIs – Camera, Image Picker & Location

---

In previous chapters, we learned:

- Navigation
- Context API
- AsyncStorage
- API Integration
- Async Operations

Modern mobile applications also interact with device hardware and native capabilities.

Examples:

- Banking apps scan cheques using camera
- Food delivery apps use GPS location
- Expense apps attach receipt images

React Native applications can access these features using Expo APIs.

In this chapter, we will integrate:

✅ Camera API
✅ Image Picker API
✅ Location API
✅ Permission Handling

into our ExpenseApp.

---

# 🎯 What You Will Learn

By the end of this chapter, you will:

- Understand device permissions
- Use Image Picker API
- Use Camera API
- Use Location API
- Handle permission requests
- Work with file URIs
- Build receipt upload features
- Attach location data to expenses
- Handle async device operations safely

---

# 📱 Understanding Device Permissions

Mobile operating systems protect user privacy by requiring explicit permission before accessing sensitive features.

Examples:

- Camera
- Gallery
- GPS Location
- Contacts
- Microphone

---

# 🔹 Why Permissions Matter

Without permission handling:

❌ Application may crash
❌ Features may fail silently
❌ Poor user experience

With proper permission handling:

✅ Better UX
✅ Better security
✅ Reliable application behavior

---

# 🔹 Permission Flow

```text id="n5jv7z"
Application Requests Permission
              ↓
User Allows or Denies
              ↓
Application Handles Result
```

---

# 🔹 Permission States

| Status       | Meaning           |
| ------------ | ----------------- |
| granted      | Access allowed    |
| denied       | User rejected     |
| undetermined | Not requested yet |

---

# 🔹 Best Practices

✅ Request permissions only when needed

✅ Explain why permission is required

✅ Handle denied permissions properly

✅ Always provide fallback behavior

---

# 🖼️ Image Picker API

Image Picker allows users to select images from the device gallery.

---

# 🔹 Install Dependency

```bash id="im1r7s"
npx expo install expo-image-picker
```

---

# 🔹 ExpenseApp Use Case

Users can:

- Select receipt images
- Attach bills to expenses
- Upload payment screenshots

---

# 🔹 Pick Image Example

📁 `src/app/add-expense.tsx`

```tsx id="9d4cl0"
import * as ImagePicker from "expo-image-picker";

const pickReceiptImage = async () => {
    try {
        const permission =
            await ImagePicker.requestMediaLibraryPermissionsAsync();

        if (!permission.granted) {
            alert("Gallery permission is required");

            return;
        }

        const result = await ImagePicker.launchImageLibraryAsync({
            mediaTypes: ImagePicker.MediaTypeOptions.Images,

            allowsEditing: true,

            quality: 0.7,
        });

        if (!result.canceled) {
            const imageUri = result.assets[0].uri;

            console.log(imageUri);
        }
    } catch (error) {
        console.log(error);
    }
};
```

---

# 🔹 Important Options

| Option        | Purpose               |
| ------------- | --------------------- |
| mediaTypes    | Image/video selection |
| allowsEditing | Crop image            |
| quality       | Compression quality   |

---

# 🔹 Why Compress Images?

Large images:

❌ Slow application
❌ Increase memory usage
❌ Increase upload time

Using:

```tsx id="xx0rb7"
quality: 0.7;
```

helps improve performance.

---

# 📷 Camera API

Camera API allows users to capture photos directly using device camera.

---

# 🔹 Install Camera Package

```bash id="7r0x7z"
npx expo install expo-camera
```

---

# 🔹 Request Camera Permission

```tsx id="4hmp3w"
import { Camera } from "expo-camera";

const requestCameraPermission = async () => {
    const { status } = await Camera.requestCameraPermissionsAsync();

    if (status !== "granted") {
        alert("Camera permission denied");

        return;
    }
};
```

---

# 🔹 Basic Camera Preview

```tsx id="1ndk0m"
<Camera
    style={{
        flex: 1,
    }}
/>
```

---

# 🔹 Capture Photo

```tsx id="yxt9tq"
const takePicture = async () => {
    if (!cameraRef.current) {
        return;
    }

    const photo = await cameraRef.current.takePictureAsync();

    console.log(photo.uri);
};
```

---

# 🔹 ExpenseApp Use Cases

Users can:

- Capture receipts instantly
- Scan bills
- Store invoice images

---

# 📍 Location API

Location API provides GPS coordinates.

---

# 🔹 Install Location Package

```bash id="9zknca"
npx expo install expo-location
```

---

# 🔹 Get Current Location

```tsx id="nvx9u4"
import * as Location from "expo-location";

const getCurrentLocation = async () => {
    try {
        const { status } = await Location.requestForegroundPermissionsAsync();

        if (status !== "granted") {
            alert("Location permission denied");

            return;
        }

        const location = await Location.getCurrentPositionAsync({});

        console.log(location.coords);
    } catch (error) {
        console.log(error);
    }
};
```

---

# 🔹 Example Location Output

```json id="dbvkg4"
{
    "latitude": 19.076,
    "longitude": 72.8777
}
```

---

# 🔹 ExpenseApp Use Cases

Location can help:

- Track spending locations
- Generate city-wise reports
- Analyze travel expenses

---

# 📁 Working with File URIs

Image Picker and Camera APIs return file URIs.

---

# 🔹 Example URI

```text id="sz1k7n"
file:///data/user/0/.../receipt.jpg
```

---

# 🔹 Display Image

```tsx id="6hxly4"
<Image
    source={{ uri: receiptUri }}
    style={{
        width: 120,
        height: 120,
    }}
/>
```

---

# 🔹 Important Notes

✅ URI is file reference only

✅ Do not store large image blobs in state

✅ Upload images to server when required

---

# 🔄 ExpenseApp Full Example

📁 `src/app/add-expense.tsx`

```tsx id="8x0d6x"
import React, { useState } from "react";

import { View, Text, TextInput, Pressable, Image } from "react-native";

import * as ImagePicker from "expo-image-picker";

import * as Location from "expo-location";

import { style } from "../styles/styles";

export default function AddExpenseScreen() {
    const [description, setDescription] = useState("");

    const [amount, setAmount] = useState("");

    const [receiptUri, setReceiptUri] = useState("");

    const [location, setLocation] = useState<any>(null);

    const pickReceiptImage = async () => {
        try {
            const permission =
                await ImagePicker.requestMediaLibraryPermissionsAsync();

            if (!permission.granted) {
                alert("Gallery permission required");

                return;
            }

            const result = await ImagePicker.launchImageLibraryAsync({
                mediaTypes: ImagePicker.MediaTypeOptions.Images,

                quality: 0.7,
            });

            if (!result.canceled) {
                setReceiptUri(result.assets[0].uri);
            }
        } catch (error) {
            console.log(error);
        }
    };

    const fetchLocation = async () => {
        try {
            const { status } =
                await Location.requestForegroundPermissionsAsync();

            if (status !== "granted") {
                alert("Location permission denied");

                return;
            }

            const currentLocation = await Location.getCurrentPositionAsync({});

            setLocation(currentLocation.coords);
        } catch (error) {
            console.log(error);
        }
    };

    const handleSaveExpense = async () => {
        const expense = {
            id: Date.now(),
            description,
            amount: Number(amount),
            receiptUri,
            location,
        };

        console.log(expense);
    };

    return (
        <View style={styles.container}>
            <Text style={styles.label}>Description</Text>

            <TextInput
                value={description}
                onChangeText={setDescription}
                placeholder="Description"
                style={styles.input}
            />

            <Text style={styles.label}>Amount</Text>

            <TextInput
                value={amount}
                onChangeText={setAmount}
                placeholder="Amount"
                keyboardType="numeric"
                style={styles.input}
            />

            <Pressable style={styles.button} onPress={pickReceiptImage}>
                <Text style={styles.buttonText}>Select Receipt</Text>
            </Pressable>

            {receiptUri ? (
                <Image
                    source={{
                        uri: receiptUri,
                    }}
                    style={{
                        width: 120,
                        height: 120,
                        marginVertical: 20,
                    }}
                />
            ) : null}

            <Pressable
                style={[
                    styles.button,
                    {
                        marginTop: 10,
                    },
                ]}
                onPress={fetchLocation}
            >
                <Text style={styles.buttonText}>Get Location</Text>
            </Pressable>

            <Pressable
                style={[
                    styles.button,
                    {
                        marginTop: 10,
                    },
                ]}
                onPress={handleSaveExpense}
            >
                <Text style={styles.buttonText}>Save Expense</Text>
            </Pressable>
        </View>
    );
}
```

---

# 🔹 Async Flow in Device APIs

```text id="qwt2gf"
User Presses Button
          ↓
Permission Requested
          ↓
User Allows Access
          ↓
Device API Executes
          ↓
Result Returned
          ↓
UI Updates
```

---

# ⚠️ Error Handling

Always handle:

- Permission denial
- API failures
- Device incompatibility
- User cancellation

---

# 🔹 Example Error Handling

```tsx id="o1v3j6"
try {
    const result = await ImagePicker.launchImageLibraryAsync();
} catch (error) {
    console.log(error);
}
```

---

# 🔹 Recommended Folder Structure

```text id="g9ep7n"
src
│
├── app
│   └── add-expense.tsx
│
├── components
│   └── receipt-preview.tsx
│
├── hooks
│   └── use-location.ts
│
├── services
│   └── expenseService.ts
│
└── styles
    └── styles.ts
```

---

# ⚡ Performance Considerations

✅ Compress large images
✅ Avoid unnecessary re-renders
✅ Avoid storing large binary data
✅ Use lazy image loading

---

# 🔐 Security Considerations

✅ Respect user privacy
✅ Request permissions carefully
✅ Avoid unnecessary location tracking
✅ Never access device APIs silently

---

# ✅ Best Practices

✅ Request permissions contextually
✅ Handle denied permissions gracefully
✅ Use async/await properly
✅ Keep UI responsive
✅ Reuse existing styles
✅ Separate business logic cleanly

---

# ⚠️ Common Mistakes

❌ Forgetting permission requests
❌ Ignoring denied permissions
❌ Blocking UI during async operations
❌ Storing large images in state
❌ No error handling
❌ Mixing too much logic in components

---

# 🧪 Practice Exercises

1. Capture image using Camera API
2. Add receipt preview component
3. Store expense location
4. Add loading indicator during image selection
5. Create reusable permission utility
6. Upload image to mock API
7. Add delete receipt functionality

---

# 📘 Chapter Summary

In this chapter, you:

✅ Learned device permission handling
✅ Used Image Picker API
✅ Used Camera API
✅ Used Location API
✅ Worked with file URIs
✅ Attached receipt images to expenses
✅ Stored GPS location data
✅ Handled async device operations safely
✅ Built real-world ExpenseApp features
