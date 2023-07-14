# LGA Polling Unit Result

This project allows you to calculate the summed total result for a specific Local Government Area (LGA) based on polling unit results.

## Table of Contents

- [Introduction](#introduction)
- [Installation](#installation)
- [Usage](#usage)
- [Database Setup](#database-setup)
- [Contributing](#contributing)
- [License](#license)

## Introduction

The LGA Polling Unit Result project provides a web-based interface to select a specific LGA and calculate the summed total result for that LGA based on the polling unit results. It utilizes PHP and MySQL for the backend and HTML/CSS for the frontend.

## Installation

To run this project locally, follow these steps:

1. Clone the repository: `git clone https://github.com/your-username/lga-polling-unit-result.git`
2. Move into the project directory: `cd lga-polling-unit-result`
3. Configure the database connection in the `config.php` file with your MySQL database credentials.
4. Import the database: Use the provided SQL file (`database.sql`) to create the necessary tables and data in your MySQL database.
5. Start a local development server or use a web server software (e.g., Apache) to host the project.
6. Access the project in your web browser using the appropriate URL.
7. Admin logins are username:Admin Password:12345
## Usage

1. Open the project in your web browser.
2. On the homepage, select a Local Government from the dropdown menu.
3. Click the "Calculate Sum" button to view the summed total result for the selected Local Government.
4. The result will be displayed in a table, showing the Local Government name and the total result.

## Database Setup

This project assumes you have a MySQL database named "inecpublicv2" already set up. If you want to use a different database name, update the `config.php` file accordingly.

The database structure consists of the following tables:

- `lga`: Contains information about the Local Government Areas.
- `polling_unit`: Stores data related to the polling units.
- `announced_pu_results`: Contains the polling unit results.

Refer to the `database.sql` file for the table structures and sample data.

## Contributing

Contributions to this project are welcome. If you find any issues or have suggestions for improvements, please feel free to open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
