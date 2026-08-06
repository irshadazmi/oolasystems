# Chapter 3: Page Object Model and Framework Design

---

In the previous chapter, we set up our Selenium project and wrote our first test. However, the test we created was not maintainable.

In this chapter, we will implement the **Page Object Model (POM)** design pattern, which is the industry standard for building maintainable test automation frameworks.

Using our Insurance Policy Management System (IPMS), we will create a robust, scalable, and maintainable test automation framework.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Understand the Page Object Model design pattern
- Create Page Object classes
- Implement a Base Page class
- Use Page Factory for element initialization
- Design a maintainable framework structure
- Implement Page Object chaining
- Understand framework design principles

---

# What is Page Object Model?

Page Object Model is a design pattern that creates an object repository for web UI elements.

```text
Traditional Approach:
Test Class → Direct Element Locators → Browser

Page Object Model:
Test Class → Page Objects → Element Locators → Browser
```

## Why Page Object Model?

| Without POM | With POM |
|-------------|----------|
| Duplicate locators | Centralized locators |
| Hard to maintain | Easy to maintain |
| No reusability | High reusability |
| Broken tests when UI changes | Only page objects need updates |
| No clear separation | Clear separation of concerns |

---

![Page Object Model](/images/tutorials/selenium/ch03-page-object-model.png)

---

# Base Page Class

The Base Page class contains common functionality for all pages.

```java
package com.insurance.pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.WebDriverWait;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.By;
import org.openqa.selenium.WebElement;
import java.time.Duration;

public abstract class BasePage {
    
    protected WebDriver driver;
    protected WebDriverWait wait;
    protected static final int DEFAULT_TIMEOUT = 10;
    
    public BasePage(WebDriver driver) {
        this.driver = driver;
        this.wait = new WebDriverWait(driver, Duration.ofSeconds(DEFAULT_TIMEOUT));
        PageFactory.initElements(driver, this);
    }
    
    // Common navigation method
    public String getPageTitle() {
        return driver.getTitle();
    }
    
    // Common wait methods
    protected void waitForVisibility(WebElement element) {
        wait.until(ExpectedConditions.visibilityOf(element));
    }
    
    protected void waitForClickable(WebElement element) {
        wait.until(ExpectedConditions.elementToBeClickable(element));
    }
    
    // Common element methods
    protected void click(WebElement element) {
        waitForClickable(element);
        element.click();
    }
    
    protected void type(WebElement element, String text) {
        waitForVisibility(element);
        element.clear();
        element.sendKeys(text);
    }
    
    protected String getText(WebElement element) {
        waitForVisibility(element);
        return element.getText();
    }
}
```

---

# Login Page Object

```java
package com.insurance.pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

public class LoginPage extends BasePage {
    
    // Element Locators
    @FindBy(id = "username")
    private WebElement usernameField;
    
    @FindBy(id = "password")
    private WebElement passwordField;
    
    @FindBy(id = "loginBtn")
    private WebElement loginButton;
    
    @FindBy(css = ".error-message")
    private WebElement errorMessage;
    
    @FindBy(linkText = "Forgot Password?")
    private WebElement forgotPasswordLink;
    
    // Constructor
    public LoginPage(WebDriver driver) {
        super(driver);
    }
    
    // Page Actions
    public DashboardPage login(String username, String password) {
        type(usernameField, username);
        type(passwordField, password);
        click(loginButton);
        return new DashboardPage(driver);
    }
    
    public boolean isLoginErrorDisplayed() {
        return errorMessage.isDisplayed();
    }
    
    public String getErrorMessage() {
        return getText(errorMessage);
    }
    
    public ForgotPasswordPage clickForgotPassword() {
        click(forgotPasswordLink);
        return new ForgotPasswordPage(driver);
    }
}
```

---

# Dashboard Page Object

```java
package com.insurance.pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

public class DashboardPage extends BasePage {
    
    @FindBy(css = ".welcome-message")
    private WebElement welcomeMessage;
    
    @FindBy(linkText = "Policies")
    private WebElement policiesLink;
    
    @FindBy(linkText = "Claims")
    private WebElement claimsLink;
    
    @FindBy(linkText = "Policy Holders")
    private WebElement policyHoldersLink;
    
    @FindBy(css = ".logout-btn")
    private WebElement logoutButton;
    
    @FindBy(css = ".user-name")
    private WebElement userName;
    
    public DashboardPage(WebDriver driver) {
        super(driver);
    }
    
    public boolean isDashboardDisplayed() {
        return welcomeMessage.isDisplayed();
    }
    
    public String getWelcomeMessage() {
        return getText(welcomeMessage);
    }
    
    public PolicyPage navigateToPolicies() {
        click(policiesLink);
        return new PolicyPage(driver);
    }
    
    public ClaimsPage navigateToClaims() {
        click(claimsLink);
        return new ClaimsPage(driver);
    }
    
    public PolicyHolderPage navigateToPolicyHolders() {
        click(policyHoldersLink);
        return new PolicyHolderPage(driver);
    }
    
    public LoginPage logout() {
        click(logoutButton);
        return new LoginPage(driver);
    }
}
```

---

# Policy Page Object

```java
package com.insurance.pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.ui.Select;

public class PolicyPage extends BasePage {
    
    @FindBy(css = ".create-policy-btn")
    private WebElement createPolicyButton;
    
    @FindBy(id = "policyType")
    private WebElement policyTypeDropdown;
    
    @FindBy(id = "coverageAmount")
    private WebElement coverageAmountField;
    
    @FindBy(id = "premiumAmount")
    private WebElement premiumAmountField;
    
    @FindBy(id = "policyHolderId")
    private WebElement policyHolderSearchField;
    
    @FindBy(id = "submitPolicy")
    private WebElement submitPolicyButton;
    
    @FindBy(css = ".policy-table")
    private WebElement policyTable;
    
    @FindBy(css = ".success-message")
    private WebElement successMessage;
    
    public PolicyPage(WebDriver driver) {
        super(driver);
    }
    
    public CreatePolicyPage clickCreatePolicy() {
        click(createPolicyButton);
        return new CreatePolicyPage(driver);
    }
    
    public void selectPolicyType(String type) {
        Select dropdown = new Select(policyTypeDropdown);
        dropdown.selectByVisibleText(type);
    }
    
    public void enterCoverageAmount(String amount) {
        type(coverageAmountField, amount);
    }
    
    public void enterPremiumAmount(String amount) {
        type(premiumAmountField, amount);
    }
    
    public void searchPolicyHolder(String searchTerm) {
        type(policyHolderSearchField, searchTerm);
    }
    
    public void submitPolicy() {
        click(submitPolicyButton);
    }
    
    public boolean isPolicyCreated() {
        return successMessage.isDisplayed();
    }
    
    public String getSuccessMessage() {
        return getText(successMessage);
    }
}
```

---

# Create Policy Page Object

```java
package com.insurance.pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.ui.Select;

public class CreatePolicyPage extends BasePage {
    
    @FindBy(id = "policyType")
    private WebElement policyType;
    
    @FindBy(id = "coverageAmount")
    private WebElement coverageAmount;
    
    @FindBy(id = "premiumAmount")
    private WebElement premiumAmount;
    
    @FindBy(id = "policyHolder")
    private WebElement policyHolder;
    
    @FindBy(id = "startDate")
    private WebElement startDate;
    
    @FindBy(id = "endDate")
    private WebElement endDate;
    
    @FindBy(id = "savePolicy")
    private WebElement saveButton;
    
    @FindBy(id = "cancel")
    private WebElement cancelButton;
    
    public CreatePolicyPage(WebDriver driver) {
        super(driver);
    }
    
    public PolicyPage createPolicy(String type, String coverage, String premium, String holder) {
        Select dropdown = new Select(policyType);
        dropdown.selectByVisibleText(type);
        
        type(coverageAmount, coverage);
        type(premiumAmount, premium);
        type(policyHolder, holder);
        
        click(saveButton);
        return new PolicyPage(driver);
    }
    
    public PolicyPage cancelCreation() {
        click(cancelButton);
        return new PolicyPage(driver);
    }
}
```

---

# Test Implementation with Page Objects

```java
package com.insurance.tests;

import com.insurance.pages.DashboardPage;
import com.insurance.pages.LoginPage;
import com.insurance.pages.PolicyPage;
import com.insurance.pages.CreatePolicyPage;
import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.testng.Assert;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

public class PolicyTest {
    
    private WebDriver driver;
    private LoginPage loginPage;
    private DashboardPage dashboardPage;
    private PolicyPage policyPage;
    private CreatePolicyPage createPolicyPage;
    
    private static final String BASE_URL = "https://insurance-app.example.com";
    private static final String USERNAME = "agent";
    private static final String PASSWORD = "password123";
    
    @BeforeMethod
    public void setup() {
        WebDriverManager.chromedriver().setup();
        driver = new ChromeDriver();
        driver.manage().window().maximize();
        driver.get(BASE_URL + "/login");
        
        loginPage = new LoginPage(driver);
        dashboardPage = loginPage.login(USERNAME, PASSWORD);
    }
    
    @Test
    public void testCreateTermLifePolicy() {
        // Navigate to policies page
        policyPage = dashboardPage.navigateToPolicies();
        
        // Click create policy button
        createPolicyPage = policyPage.clickCreatePolicy();
        
        // Create policy
        policyPage = createPolicyPage.createPolicy(
            "Term Life",
            "500000",
            "2500",
            "John Smith"
        );
        
        // Verify policy created
        Assert.assertTrue(policyPage.isPolicyCreated(), "Policy not created");
        Assert.assertEquals(policyPage.getSuccessMessage(), 
            "Policy created successfully");
    }
    
    @Test
    public void testCancelPolicyCreation() {
        policyPage = dashboardPage.navigateToPolicies();
        createPolicyPage = policyPage.clickCreatePolicy();
        
        // Cancel creation
        policyPage = createPolicyPage.cancelCreation();
        
        // Verify creation cancelled
        Assert.assertTrue(policyPage.isPolicyTableDisplayed(), 
            "Policy table not displayed");
    }
    
    @Test
    public void testLogout() {
        LoginPage logoutPage = dashboardPage.logout();
        Assert.assertTrue(logoutPage.isLoginPageDisplayed());
    }
    
    @AfterMethod
    public void teardown() {
        if (driver != null) {
            driver.quit();
        }
    }
}
```

---

# Page Factory Implementation

## Using @FindBy Annotations

```java
@FindBy(id = "username")
private WebElement usernameField;

@FindBy(xpath = "//button[@type='submit']")
private WebElement submitButton;

@FindBy(css = ".error-message")
private WebElement errorMessage;

@FindBy(className = "policy-card")
private List<WebElement> policyCards;
```

## Using @FindBys (Multiple locators)

```java
@FindBys({
    @FindBy(css = ".login-form"),
    @FindBy(id = "username")
})
private WebElement usernameField;
```

## Using @FindAll (OR condition)

```java
@FindAll({
    @FindBy(id = "username"),
    @FindBy(name = "username")
})
private WebElement usernameField;
```

---

# Page Object Chaining

```java
// Method chaining for fluent API
public LoginPage login(String username, String password) {
    type(usernameField, username);
    type(passwordField, password);
    click(loginButton);
    return new DashboardPage(driver);
}

// Usage
String welcomeMessage = loginPage
    .login("agent", "password123")
    .navigateToPolicies()
    .clickCreatePolicy()
    .createPolicy("Term Life", "500000", "2500", "John Smith")
    .getSuccessMessage();
```

---

# Framework Package Structure

```text
src/main/java/com/insurance/
│
├── pages/
│   ├── BasePage.java
│   ├── LoginPage.java
│   ├── DashboardPage.java
│   ├── PolicyPage.java
│   ├── CreatePolicyPage.java
│   ├── ClaimsPage.java
│   └── PolicyHolderPage.java
│
├── components/
│   ├── HeaderComponent.java
│   ├── FooterComponent.java
│   └── SidebarComponent.java
│
├── utils/
│   ├── DriverManager.java
│   ├── ConfigReader.java
│   ├── TestDataUtils.java
│   ├── ExcelUtils.java
│   └── ReportUtils.java
│
├── enums/
│   ├── PolicyType.java
│   └── ClaimStatus.java
│
└── exceptions/
    ├── ElementNotFoundException.java
    └── TestFrameworkException.java
```

---

# Framework Structure Diagram

![Framework Structure](/images/tutorials/selenium/ch03-framework-structure.png)

---

# Config Reader Utility

```java
package com.insurance.utils;

import java.io.InputStream;
import java.util.Properties;

public class ConfigReader {
    
    private static Properties properties;
    
    static {
        try {
            properties = new Properties();
            InputStream input = ConfigReader.class
                .getClassLoader()
                .getResourceAsStream("config.properties");
            properties.load(input);
        } catch (Exception e) {
            throw new RuntimeException("Failed to load config.properties", e);
        }
    }
    
    public static String getProperty(String key) {
        return properties.getProperty(key);
    }
    
    public static String getBaseUrl() {
        return getProperty("base.url");
    }
    
    public static String getBrowser() {
        return getProperty("browser");
    }
    
    public static int getTimeout() {
        return Integer.parseInt(getProperty("timeout"));
    }
}
```

---

# config.properties File

```properties
# Application Configuration
base.url=https://insurance-app.example.com
browser=chrome

# Timeouts
timeout=10
implicit.timeout=5
page.load.timeout=30

# Test Data
username=agent
password=password123

# Report Configuration
report.path=./test-output/
screenshot.on.failure=true
```

---

# Driver Manager Utility

```java
package com.insurance.utils;

import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.edge.EdgeDriver;
import java.time.Duration;

public class DriverManager {
    
    private static WebDriver driver;
    
    public static WebDriver getDriver() {
        if (driver == null) {
            initializeDriver();
        }
        return driver;
    }
    
    private static void initializeDriver() {
        String browser = ConfigReader.getBrowser();
        
        switch (browser.toLowerCase()) {
            case "chrome":
                WebDriverManager.chromedriver().setup();
                ChromeOptions options = new ChromeOptions();
                options.addArguments("--start-maximized");
                if (isHeadless()) {
                    options.addArguments("--headless");
                }
                driver = new ChromeDriver(options);
                break;
                
            case "firefox":
                WebDriverManager.firefoxdriver().setup();
                driver = new FirefoxDriver();
                break;
                
            case "edge":
                WebDriverManager.edgedriver().setup();
                driver = new EdgeDriver();
                break;
                
            default:
                throw new IllegalArgumentException("Unsupported browser: " + browser);
        }
        
        driver.manage().timeouts().implicitlyWait(
            Duration.ofSeconds(ConfigReader.getTimeout())
        );
        driver.manage().window().maximize();
    }
    
    private static boolean isHeadless() {
        return Boolean.parseBoolean(ConfigReader.getProperty("headless"));
    }
    
    public static void quitDriver() {
        if (driver != null) {
            driver.quit();
            driver = null;
        }
    }
}
```

---

# Test with DriverManager

```java
package com.insurance.tests;

import com.insurance.pages.LoginPage;
import com.insurance.pages.DashboardPage;
import com.insurance.utils.DriverManager;
import com.insurance.utils.ConfigReader;
import org.openqa.selenium.WebDriver;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

public class LoginTest {
    
    private WebDriver driver;
    private LoginPage loginPage;
    
    @BeforeMethod
    public void setup() {
        driver = DriverManager.getDriver();
        driver.get(ConfigReader.getBaseUrl() + "/login");
        loginPage = new LoginPage(driver);
    }
    
    @Test
    public void testValidLogin() {
        DashboardPage dashboardPage = loginPage.login(
            ConfigReader.getProperty("username"),
            ConfigReader.getProperty("password")
        );
        assert dashboardPage.isDashboardDisplayed();
    }
    
    @AfterMethod
    public void teardown() {
        DriverManager.quitDriver();
    }
}
```

---

# Page Object Flow

![Page Object Flow](/images/tutorials/selenium/ch03-page-flow.png)

---

# Best Practices

✅ Use Page Object Model for all pages

✅ Keep page objects independent of test data

✅ Use meaningful method names

✅ Implement BasePage for common functionality

✅ Use Page Factory for element initialization

✅ Keep tests focused on single functionality

✅ Use constants for string values

✅ Implement proper exception handling

---

# Common Mistakes

❌ Adding assertions in page objects

❌ Hardcoding URLs in page objects

❌ Mixing test logic with page logic

❌ Not using explicit waits

❌ Creating page objects without BasePage

❌ Duplicating locators across page objects

❌ Not handling dynamic elements properly

---

# Interview Questions

1. What is Page Object Model?

2. Why is POM important?

3. What is Page Factory?

4. Difference between POM and Page Factory?

5. How do you handle dynamic elements in POM?

6. What is BasePage and why use it?

7. What is page object chaining?

8. How do you manage multiple page objects?

9. What is the driver management pattern?

10. How do you handle component reuse?

---

# Practice Exercises

1. Create a Page Object for the Policy Search page.

2. Implement a HeaderComponent for common navigation.

3. Create a test that creates multiple policies using data provider.

4. Implement page object chaining for a complete workflow.

5. Add screenshot capture on test failure.

---

# Key Takeaways

- Page Object Model is the industry standard for test automation.
- BasePage centralizes common functionality.
- Page Factory simplifies element initialization.
- DriverManager handles driver lifecycle.
- Good framework design improves maintainability.

---

# Chapter Summary

In this chapter, you learned:

- Page Object Model design pattern
- Base Page implementation
- Page Factory annotations
- Page object chaining
- Framework package structure
- Config Reader utility
- Driver Manager implementation
- Best practices for framework design

You now have a complete, maintainable test automation framework and are ready to implement advanced features.

---

## Next Chapter

👉 Next Chapter: Advanced Selenium and Test Data Management