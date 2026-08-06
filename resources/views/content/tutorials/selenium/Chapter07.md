# Chapter 7: Capstone Project - Enterprise Insurance Test Automation

---

Congratulations! You have reached the final chapter of this tutorial.

In this chapter, we will bring everything together and build a complete **Enterprise Insurance Policy Management Test Automation Framework**.

This capstone project will consolidate all concepts learned throughout this tutorial into a production-ready test automation solution.

---

# 🎯 Learning Objectives

By the end of this chapter, you will be able to:

- Build a complete enterprise test automation framework
- Implement all design patterns and best practices
- Create comprehensive test suites for IPMS
- Integrate with CI/CD pipelines
- Generate professional test reports
- Implement AI-powered testing capabilities
- Deliver a production-ready test automation solution

---

# Capstone Project Overview

## Project Name

```text
Insurance Policy Management System (IPMS) - Test Automation Framework
```

## Project Goal

Build a complete, enterprise-grade test automation framework that validates all critical business workflows of the Insurance Policy Management System.

## Key Deliverables

```text
✅ Page Object Model framework
✅ Comprehensive test suites
✅ Data-driven testing
✅ Cross-browser testing
✅ CI/CD integration
✅ Professional reporting
✅ AI-enhanced testing
```

---

# Project Architecture

---

![Capstone Architecture](/images/tutorials/selenium/ch07-capstone-architecture.png)

---

# Project Structure

```text
insurance-test-automation/
│
├── src/
│   ├── main/
│   │   └── java/
│   │       └── com/insurance/
│   │           ├── pages/
│   │           │   ├── BasePage.java
│   │           │   ├── LoginPage.java
│   │           │   ├── DashboardPage.java
│   │           │   ├── PolicyPage.java
│   │           │   ├── CreatePolicyPage.java
│   │           │   ├── ClaimsPage.java
│   │           │   ├── CreateClaimPage.java
│   │           │   ├── PaymentPage.java
│   │           │   └── PolicyHolderPage.java
│   │           │
│   │           ├── components/
│   │           │   ├── HeaderComponent.java
│   │           │   └── NavigationComponent.java
│   │           │
│   │           ├── utils/
│   │           │   ├── DriverManager.java
│   │           │   ├── ConfigReader.java
│   │           │   ├── JsonDataReader.java
│   │           │   ├── ExcelUtils.java
│   │           │   ├── ScreenshotUtils.java
│   │           │   └── TestDataGenerator.java
│   │           │
│   │           ├── listeners/
│   │           │   ├── TestListener.java
│   │           │   ├── RetryAnalyzer.java
│   │           │   └── AllureListener.java
│   │           │
│   │           ├── enums/
│   │           │   ├── PolicyType.java
│   │           │   ├── ClaimStatus.java
│   │           │   └── PaymentStatus.java
│   │           │
│   │           └── exceptions/
│   │               ├── ElementNotFoundException.java
│   │               └── FrameworkException.java
│   │
│   └── test/
│       └── java/
│           └── com/insurance/tests/
│               ├── suite/
│               │   └── TestSuite.java
│               ├── LoginTest.java
│               ├── PolicyTest.java
│               ├── ClaimTest.java
│               ├── PaymentTest.java
│               └── RegressionTest.java
│
├── resources/
│   ├── config.properties
│   ├── testng.xml
│   ├── log4j2.xml
│   ├── testdata/
│   │   ├── policies.json
│   │   ├── claims.json
│   │   └── payments.json
│   └── reports/
│       └── allure.properties
│
├── docker/
│   ├── Dockerfile
│   └── docker-compose.yml
│
├── Jenkinsfile
├── .github/
│   └── workflows/
│       └── selenium-tests.yml
│
├── pom.xml
└── README.md
```

---

# Complete Page Object Implementation

## BasePage.java

```java
package com.insurance.pages;

import com.insurance.utils.ScreenshotUtils;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.PageFactory;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;
import java.time.Duration;

public abstract class BasePage {
    
    protected WebDriver driver;
    protected WebDriverWait wait;
    protected JavascriptExecutor js;
    protected ScreenshotUtils screenshotUtils;
    
    protected static final int DEFAULT_TIMEOUT = 10;
    protected static final int PAGE_LOAD_TIMEOUT = 30;
    
    public BasePage(WebDriver driver) {
        this.driver = driver;
        this.wait = new WebDriverWait(driver, Duration.ofSeconds(DEFAULT_TIMEOUT));
        this.js = (JavascriptExecutor) driver;
        this.screenshotUtils = new ScreenshotUtils(driver);
        PageFactory.initElements(driver, this);
    }
    
    protected void click(WebElement element) {
        wait.until(ExpectedConditions.elementToBeClickable(element));
        try {
            element.click();
        } catch (Exception e) {
            // Fallback to JavaScript click
            js.executeScript("arguments[0].click();", element);
        }
    }
    
    protected void type(WebElement element, String text) {
        wait.until(ExpectedConditions.visibilityOf(element));
        element.clear();
        element.sendKeys(text);
    }
    
    protected String getText(WebElement element) {
        wait.until(ExpectedConditions.visibilityOf(element));
        return element.getText();
    }
    
    protected void waitForPageLoad() {
        wait.until(driver -> js.executeScript("return document.readyState")
            .equals("complete"));
    }
    
    protected void scrollToElement(WebElement element) {
        js.executeScript("arguments[0].scrollIntoView(true);", element);
    }
    
    protected void highlightElement(WebElement element) {
        js.executeScript(
            "arguments[0].style.border='3px solid purple';", 
            element
        );
    }
    
    public String getPageTitle() {
        return driver.getTitle();
    }
    
    public String getCurrentUrl() {
        return driver.getCurrentUrl();
    }
}
```

---

## LoginPage.java

```java
package com.insurance.pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;

public class LoginPage extends BasePage {
    
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
    
    @FindBy(className = "login-header")
    private WebElement loginHeader;
    
    public LoginPage(WebDriver driver) {
        super(driver);
    }
    
    public DashboardPage login(String username, String password) {
        type(usernameField, username);
        type(passwordField, password);
        click(loginButton);
        waitForPageLoad();
        
        try {
            return new DashboardPage(driver);
        } catch (Exception e) {
            // Login failed
            return this;
        }
    }
    
    public LoginPage loginWithError(String username, String password) {
        type(usernameField, username);
        type(passwordField, password);
        click(loginButton);
        return this;
    }
    
    public String getErrorMessage() {
        return getText(errorMessage);
    }
    
    public boolean isErrorDisplayed() {
        try {
            return errorMessage.isDisplayed();
        } catch (Exception e) {
            return false;
        }
    }
    
    public ForgotPasswordPage clickForgotPassword() {
        click(forgotPasswordLink);
        return new ForgotPasswordPage(driver);
    }
    
    public boolean isLoginPageDisplayed() {
        try {
            wait.until(ExpectedConditions.visibilityOf(loginHeader));
            return loginHeader.isDisplayed();
        } catch (Exception e) {
            return false;
        }
    }
}
```

---

## DashboardPage.java

```java
package com.insurance.pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import java.util.List;

public class DashboardPage extends BasePage {
    
    @FindBy(css = ".welcome-message")
    private WebElement welcomeMessage;
    
    @FindBy(css = ".user-name")
    private WebElement userName;
    
    @FindBy(linkText = "Policies")
    private WebElement policiesLink;
    
    @FindBy(linkText = "Claims")
    private WebElement claimsLink;
    
    @FindBy(linkText = "Policy Holders")
    private WebElement policyHoldersLink;
    
    @FindBy(linkText = "Payments")
    private WebElement paymentsLink;
    
    @FindBy(linkText = "Reports")
    private WebElement reportsLink;
    
    @FindBy(css = ".dashboard-stat")
    private List<WebElement> dashboardStats;
    
    @FindBy(css = ".logout-btn")
    private WebElement logoutButton;
    
    public DashboardPage(WebDriver driver) {
        super(driver);
    }
    
    public boolean isDashboardDisplayed() {
        try {
            wait.until(ExpectedConditions.visibilityOf(welcomeMessage));
            return welcomeMessage.isDisplayed();
        } catch (Exception e) {
            return false;
        }
    }
    
    public String getWelcomeMessage() {
        return getText(welcomeMessage);
    }
    
    public String getUserName() {
        return getText(userName);
    }
    
    public PolicyPage navigateToPolicies() {
        click(policiesLink);
        waitForPageLoad();
        return new PolicyPage(driver);
    }
    
    public ClaimsPage navigateToClaims() {
        click(claimsLink);
        waitForPageLoad();
        return new ClaimsPage(driver);
    }
    
    public PolicyHolderPage navigateToPolicyHolders() {
        click(policyHoldersLink);
        waitForPageLoad();
        return new PolicyHolderPage(driver);
    }
    
    public PaymentPage navigateToPayments() {
        click(paymentsLink);
        waitForPageLoad();
        return new PaymentPage(driver);
    }
    
    public int getDashboardStatsCount() {
        return dashboardStats.size();
    }
    
    public LoginPage logout() {
        click(logoutButton);
        return new LoginPage(driver);
    }
}
```

---

## PolicyPage.java

```java
package com.insurance.pages;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.ui.Select;
import java.util.List;

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
    
    @FindBy(css = ".policy-table tbody tr")
    private List<WebElement> policyRows;
    
    @FindBy(css = ".success-message")
    private WebElement successMessage;
    
    @FindBy(css = ".policy-search-input")
    private WebElement searchInput;
    
    @FindBy(css = ".search-btn")
    private WebElement searchButton;
    
    public PolicyPage(WebDriver driver) {
        super(driver);
    }
    
    public CreatePolicyPage clickCreatePolicy() {
        click(createPolicyButton);
        waitForPageLoad();
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
        waitForPageLoad();
    }
    
    public void createPolicy(String type, String coverage, String premium, String holder) {
        selectPolicyType(type);
        enterCoverageAmount(coverage);
        enterPremiumAmount(premium);
        searchPolicyHolder(holder);
        submitPolicy();
    }
    
    public boolean isPolicyCreated() {
        try {
            wait.until(ExpectedConditions.visibilityOf(successMessage));
            return successMessage.isDisplayed();
        } catch (Exception e) {
            return false;
        }
    }
    
    public String getSuccessMessage() {
        return getText(successMessage);
    }
    
    public int getPolicyCount() {
        return policyRows.size();
    }
    
    public boolean isPolicyTableDisplayed() {
        try {
            return !policyRows.isEmpty();
        } catch (Exception e) {
            return false;
        }
    }
    
    public void searchPolicy(String searchTerm) {
        type(searchInput, searchTerm);
        click(searchButton);
        waitForPageLoad();
    }
}
```

---

## CreatePolicyPage.java

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
    
    @FindBy(id = "beneficiary")
    private WebElement beneficiary;
    
    @FindBy(id = "savePolicy")
    private WebElement saveButton;
    
    @FindBy(id = "cancelBtn")
    private WebElement cancelButton;
    
    public CreatePolicyPage(WebDriver driver) {
        super(driver);
    }
    
    public PolicyPage createPolicy(String type, String coverage, String premium, 
                                   String holder, String startDateStr, 
                                   String endDateStr, String beneficiaryName) {
        Select dropdown = new Select(policyType);
        dropdown.selectByVisibleText(type);
        
        type(coverageAmount, coverage);
        type(premiumAmount, premium);
        type(policyHolder, holder);
        type(startDate, startDateStr);
        type(endDate, endDateStr);
        type(beneficiary, beneficiaryName);
        
        click(saveButton);
        waitForPageLoad();
        return new PolicyPage(driver);
    }
    
    public PolicyPage cancelCreation() {
        click(cancelButton);
        waitForPageLoad();
        return new PolicyPage(driver);
    }
}
```

---

![Framework Execution Flow](/images/tutorials/selenium/ch07-framework-flow.png)

---

# Complete Test Implementation

## PolicyTest.java

```java
package com.insurance.tests;

import com.insurance.pages.DashboardPage;
import com.insurance.pages.LoginPage;
import com.insurance.pages.PolicyPage;
import com.insurance.pages.CreatePolicyPage;
import com.insurance.listeners.RetryAnalyzer;
import com.insurance.utils.JsonDataReader;
import com.insurance.utils.DriverManager;
import com.insurance.utils.ConfigReader;
import org.openqa.selenium.WebDriver;
import org.testng.Assert;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;
import java.util.List;
import java.util.Map;

public class PolicyTest {
    
    private WebDriver driver;
    private LoginPage loginPage;
    private DashboardPage dashboardPage;
    private PolicyPage policyPage;
    private CreatePolicyPage createPolicyPage;
    
    private static final String BASE_URL = ConfigReader.getBaseUrl();
    private static final String USERNAME = ConfigReader.getProperty("username");
    private static final String PASSWORD = ConfigReader.getProperty("password");
    
    @BeforeMethod
    public void setup() {
        driver = DriverManager.getDriver();
        driver.get(BASE_URL + "/login");
        loginPage = new LoginPage(driver);
        dashboardPage = loginPage.login(USERNAME, PASSWORD);
        policyPage = dashboardPage.navigateToPolicies();
    }
    
    @Test(priority = 1, retryAnalyzer = RetryAnalyzer.class)
    public void testCreateTermLifePolicy() {
        createPolicyPage = policyPage.clickCreatePolicy();
        createPolicyPage.createPolicy(
            "Term Life",
            "500000",
            "2500",
            "John Smith",
            "2024-01-01",
            "2034-01-01",
            "Mary Smith"
        );
        
        Assert.assertTrue(policyPage.isPolicyCreated(), "Policy creation failed");
        Assert.assertEquals(policyPage.getSuccessMessage(), 
            "Policy created successfully");
    }
    
    @Test(priority = 2, retryAnalyzer = RetryAnalyzer.class)
    public void testCreateWholeLifePolicy() {
        createPolicyPage = policyPage.clickCreatePolicy();
        createPolicyPage.createPolicy(
            "Whole Life",
            "1000000",
            "5000",
            "Jane Doe",
            "2024-01-01",
            "2074-01-01",
            "Tom Doe"
        );
        
        Assert.assertTrue(policyPage.isPolicyCreated(), "Policy creation failed");
    }
    
    @Test(priority = 3, retryAnalyzer = RetryAnalyzer.class)
    public void testCancelPolicyCreation() {
        createPolicyPage = policyPage.clickCreatePolicy();
        createPolicyPage.cancelCreation();
        
        Assert.assertTrue(policyPage.isPolicyTableDisplayed(), 
            "Policy table not displayed after cancellation");
    }
    
    @Test(priority = 4)
    public void testSearchPolicy() {
        policyPage.searchPolicy("LIFE");
        Assert.assertTrue(policyPage.getPolicyCount() > 0, 
            "No policies found for search term");
    }
    
    @Test(priority = 5, dataProvider = "policyData")
    public void testCreateMultiplePolicies(String type, String coverage, 
                                           String premium, String holder) {
        createPolicyPage = policyPage.clickCreatePolicy();
        createPolicyPage.createPolicy(type, coverage, premium, holder,
            "2024-01-01", "2034-01-01", "Default Beneficiary");
        
        Assert.assertTrue(policyPage.isPolicyCreated(), 
            "Policy creation failed for: " + type);
    }
    
    @org.testng.annotations.DataProvider(name = "policyData")
    public Object[][] getPolicyData() {
        List<Map<String, String>> policies = 
            JsonDataReader.getTestData("policies.json", "policies");
        
        Object[][] data = new Object[policies.size()][4];
        for (int i = 0; i < policies.size(); i++) {
            data[i][0] = policies.get(i).get("type");
            data[i][1] = policies.get(i).get("coverageAmount");
            data[i][2] = policies.get(i).get("premiumAmount");
            data[i][3] = policies.get(i).get("policyHolder");
        }
        return data;
    }
    
    @AfterMethod
    public void teardown() {
        DriverManager.quitDriver();
    }
}
```

---

## LoginTest.java

```java
package com.insurance.tests;

import com.insurance.pages.DashboardPage;
import com.insurance.pages.LoginPage;
import com.insurance.utils.DriverManager;
import com.insurance.utils.ConfigReader;
import org.openqa.selenium.WebDriver;
import org.testng.Assert;
import org.testng.annotations.AfterMethod;
import org.testng.annotations.BeforeMethod;
import org.testng.annotations.Test;

public class LoginTest {
    
    private WebDriver driver;
    private LoginPage loginPage;
    
    private static final String BASE_URL = ConfigReader.getBaseUrl();
    
    @BeforeMethod
    public void setup() {
        driver = DriverManager.getDriver();
        driver.get(BASE_URL + "/login");
        loginPage = new LoginPage(driver);
    }
    
    @Test(priority = 1)
    public void testValidLogin() {
        DashboardPage dashboardPage = loginPage.login(
            ConfigReader.getProperty("username"),
            ConfigReader.getProperty("password")
        );
        
        Assert.assertTrue(dashboardPage.isDashboardDisplayed(), 
            "Login failed - Dashboard not displayed");
        Assert.assertEquals(dashboardPage.getUserName(), 
            "Agent", "Incorrect user name displayed");
    }
    
    @Test(priority = 2)
    public void testInvalidLoginWithWrongPassword() {
        loginPage.loginWithError(
            ConfigReader.getProperty("username"), 
            "wrongpassword"
        );
        
        Assert.assertTrue(loginPage.isErrorDisplayed(), 
            "Error message not displayed for invalid login");
        Assert.assertEquals(loginPage.getErrorMessage(), 
            "Invalid username or password");
    }
    
    @Test(priority = 3)
    public void testInvalidLoginWithEmptyCredentials() {
        loginPage.loginWithError("", "");
        
        Assert.assertTrue(loginPage.isErrorDisplayed(), 
            "Error message not displayed for empty credentials");
    }
    
    @Test(priority = 4)
    public void testForgotPasswordLink() {
        loginPage.clickForgotPassword();
        Assert.assertTrue(driver.getCurrentUrl().contains("forgot-password"),
            "Forgot password page not loaded");
    }
    
    @AfterMethod
    public void teardown() {
        DriverManager.quitDriver();
    }
}
```

---

# Configuration Files

## config.properties

```properties
# Application Configuration
base.url=https://insurance-app.example.com
browser=chrome
headless=false

# Timeouts
implicit.timeout=10
explicit.timeout=15
page.load.timeout=30

# Test Data
username=agent
password=password123

# Report Configuration
screenshot.on.failure=true
report.path=./test-output/

# Grid Configuration
grid.enabled=false
grid.url=http://localhost:4444

# Test Execution
parallel.execution=true
thread.count=4
```

---

## testng.xml

```xml
<!DOCTYPE suite SYSTEM "http://testng.org/testng-1.0.dtd">
<suite name="Insurance Test Suite" parallel="tests" thread-count="4">
    
    <listeners>
        <listener class-name="com.insurance.listeners.TestListener"/>
        <listener class-name="com.insurance.listeners.AllureListener"/>
    </listeners>
    
    <test name="Login Tests">
        <classes>
            <class name="com.insurance.tests.LoginTest"/>
        </classes>
    </test>
    
    <test name="Policy Tests">
        <classes>
            <class name="com.insurance.tests.PolicyTest"/>
        </classes>
    </test>
    
    <test name="Regression Suite">
        <packages>
            <package name="com.insurance.tests.*"/>
        </packages>
        <classes>
            <class name="com.insurance.tests.LoginTest"/>
            <class name="com.insurance.tests.PolicyTest"/>
            <class name="com.insurance.tests.ClaimTest"/>
            <class name="com.insurance.tests.PaymentTest"/>
        </classes>
    </test>
    
</suite>
```

---

# GitHub Actions Workflow

## .github/workflows/selenium-tests.yml

```yaml
name: Selenium Test Automation

on:
  push:
    branches: [ main, develop, release/* ]
  pull_request:
    branches: [ main ]
  workflow_dispatch:
  schedule:
    - cron: '0 2 * * *'

jobs:
  test:
    runs-on: ubuntu-latest
    
    strategy:
      fail-fast: false
      matrix:
        browser: [chrome, firefox, edge]
    
    steps:
    - name: Checkout code
      uses: actions/checkout@v3
    
    - name: Setup JDK 21
      uses: actions/setup-java@v3
      with:
        java-version: '21'
        distribution: 'temurin'
    
    - name: Setup Browsers
      run: |
        sudo apt-get update
        sudo apt-get install -y chromium-browser firefox
        sudo apt-get install -y microsoft-edge-stable
    
    - name: Cache Maven dependencies
      uses: actions/cache@v3
      with:
        path: ~/.m2/repository
        key: ${{ runner.os }}-maven-${{ hashFiles('**/pom.xml') }}
        restore-keys: |
          ${{ runner.os }}-maven-
    
    - name: Run Tests on ${{ matrix.browser }}
      run: |
        mvn clean test -Dbrowser=${{ matrix.browser }} \
                       -Dheadless=true \
                       -Dtest=*Test
    
    - name: Upload Test Reports
      if: always()
      uses: actions/upload-artifact@v3
      with:
        name: test-reports-${{ matrix.browser }}
        path: |
          target/surefire-reports/
          test-output/
    
    - name: Upload Screenshots
      if: failure()
      uses: actions/upload-artifact@v3
      with:
        name: screenshots-${{ matrix.browser }}
        path: test-output/screenshots/
```

---

# Docker Configuration

## docker-compose.yml

```yaml
version: '3.8'

services:
  selenium-hub:
    image: selenium/hub:4.15.0
    container_name: selenium-hub
    ports:
      - "4442:4442"
      - "4443:4443"
      - "4444:4444"
    networks:
      - grid-network

  chrome-node:
    image: selenium/node-chrome:4.15.0
    depends_on:
      - selenium-hub
    environment:
      - SE_EVENT_BUS_HOST=selenium-hub
      - SE_EVENT_BUS_PUBLISH_PORT=4442
      - SE_EVENT_BUS_SUBSCRIBE_PORT=4443
    volumes:
      - /dev/shm:/dev/shm
    networks:
      - grid-network

  firefox-node:
    image: selenium/node-firefox:4.15.0
    depends_on:
      - selenium-hub
    environment:
      - SE_EVENT_BUS_HOST=selenium-hub
      - SE_EVENT_BUS_PUBLISH_PORT=4442
      - SE_EVENT_BUS_SUBSCRIBE_PORT=4443
    volumes:
      - /dev/shm:/dev/shm
    networks:
      - grid-network

  test-runner:
    build: .
    depends_on:
      - selenium-hub
      - chrome-node
      - firefox-node
    environment:
      - GRID_URL=http://selenium-hub:4444
    volumes:
      - ./test-output:/app/target/surefire-reports
    networks:
      - grid-network

networks:
  grid-network:
    driver: bridge
```

---

# Project Deliverables Checklist

## ✅ Framework Components

```text
[✓] Page Object Model implementation
[✓] BasePage with common functionality
[✓] Complete page objects for IPMS
[✓] DriverManager for browser management
[✓] ConfigReader for environment configuration
[✓] Data-driven testing with JSON/Excel
[✓] TestNG test suite organization
[✓] Retry mechanism for flaky tests
[✓] Screenshot capture on failure
[✓] Allure/ExtentReports integration
[✓] Cross-browser testing support
[✓] Parallel test execution
[✓] CI/CD integration (GitHub Actions/Jenkins)
[✓] Docker containerization
[✓] Selenium Grid integration
[✓] AI-powered testing capabilities
[✓] Comprehensive test coverage
[✓] Professional documentation
```

---

![Project Deliverables](/images/tutorials/selenium/ch07-project-deliverables.png)

---

# Test Execution Commands

```bash
# Run all tests
mvn clean test

# Run specific test class
mvn test -Dtest=LoginTest

# Run with specific browser
mvn test -Dbrowser=chrome

# Run in headless mode
mvn test -Dheadless=true

# Run with specific testng.xml
mvn test -Dsurefire.suiteXmlFiles=testng.xml

# Generate Allure report
mvn allure:report
mvn allure:serve

# Run with Docker
docker-compose up -d
docker-compose run test-runner

# Run with Selenium Grid
mvn test -Dgrid.enabled=true -Dgrid.url=http://localhost:4444
```

---

# Best Practices Applied

✅ **Page Object Model** - All pages have corresponding page objects

✅ **Single Responsibility** - Each class has a single purpose

✅ **DRY Principle** - Common code centralized in BasePage

✅ **Data-Driven** - Test data separated from test logic

✅ **Independent Tests** - Tests can run in any order

✅ **Proper Waits** - All interactions use explicit waits

✅ **Error Handling** - Comprehensive exception handling

✅ **Reporting** - Detailed test reports with screenshots

✅ **CI/CD Ready** - Fully integrated with CI/CD pipelines

---

# Key Takeaways

- A complete enterprise test automation framework requires multiple layers.
- Page Object Model is essential for maintainability.
- Data-driven testing improves test coverage.
- CI/CD integration enables continuous quality.
- AI tools enhance test automation productivity.
- Good framework design reduces maintenance effort.

---

# Congratulations! 🎉

You have successfully completed the **Enterprise Test Automation with Selenium** tutorial.

You now have the skills to:

```text
✅ Design and build enterprise test automation frameworks
✅ Implement Page Object Model
✅ Create comprehensive test suites
✅ Integrate with CI/CD pipelines
✅ Use AI-powered testing tools
✅ Generate professional test reports
✅ Deploy Docker containers
✅ Execute parallel and cross-browser tests
✅ Deliver production-ready test automation solutions
```

---

# Next Steps

1. Apply these skills to your organization's applications
2. Explore advanced topics like BDD with Cucumber
3. Investigate mobile testing with Appium
4. Learn performance testing with JMeter
5. Explore API testing with RestAssured
6. Dive deeper into AI-powered testing tools

---

## Capstone Project Complete

You have now built a complete enterprise test automation framework for the Insurance Policy Management System.