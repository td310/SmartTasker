# SmartTasker

### AI-Powered Features for Smarter Project Management

<p align="justify">To improve automation and ensure clarity in IT project workflows, this system integrates several AI-based features. These functionalities help classify projects, validate task relevance, and prioritize work based on urgency and context. Below are the three key AI features currently supported:</p>

---

#### 1. IT Project Classification

Automatically determines whether a newly created project belongs to the **Information Technology (IT)** domain.

* The AI analyzes the project’s **title and description**.
* If the content mentions IT-related topics like `web`, `mobile`, `software`, `AI`, `cloud`, `API`, etc., the system accepts the project and returns:

  ```json
  { "isIT": "yes", "confidence": 0.92 }
  ```
* Projects unrelated to IT (e.g., agriculture, construction, or general education) are rejected to keep the system focused on tech-based domains.

---

#### 2. Task–Project Relevance Check

Ensures that every task added to a project is **contextually appropriate** and aligned with the project’s goals.

* The AI is prompted with a question like:
  `"Is task X relevant to project Y?"`
  It returns either `"yes"` or `"no"`.
<p align="justify">* If a task does not logically fit the project scope (e.g., a maintenance task in a software development project), the system blocks it to maintain consistency and purpose.</p>

---

#### 3. Task Priority Prediction

Automatically predicts the **priority level** of a task to support better time and workload management.

* Inputs used for prediction include:

  * Task **title**
  * Task **description**
  * Task **deadline**
  * Project **title and description**

* The AI evaluates:

  * Urgency-related keywords (e.g., `"urgent"`, `"ASAP"`, `"critical"`)
  * Deadline proximity (how close the deadline is)
  * Project context (e.g., development vs. production phase)
  * Potential impact (e.g., tasks involving login, payment, or core features)

* Returns a structured JSON object like:

  ```json
  { "priority": "high", "confidence": 0.88 }
  ```

<p align="justify">If `confidence < 0.5`, the system does not auto-assign a priority and instead asks the user to choose manually. This avoids incorrect prioritization when data is insufficient or ambiguous.</p>

---
## Requirements

-   Php 8.2 and above
-   Composer
-   Laravel >= 9.0

## Installation
-   Clone the repository

```shell
git clone https://github.com/td310/Task-Management.git
```

-   Head to the project's directory

```shell
cd task-management
```

-   Install composer dependancies

```shell
composer install
```

-   Copy .env.example file into .env file and configure based on your environment

```shell
cp .env.example .env
```

-   Generate encryption key

```shell
php artisan key:generate
```

-   Migrate the database

```shell
php artisan migrate
```

-   Install npm dependancies

```shell
npm install
```

-   Run project

```shell
npm run dev
```

```shell
php artisan serve
```

## Setup
-   Create an account
-   Login into your Account
