<?php
// Assuming you have the database connection set up
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inecpublicv2";

// Function to get the summed total result for a specific local government
function getSummedTotalResult($conn, $localGovernmentID) {
    $stmt = $conn->prepare("SELECT lga.lga_name, COALESCE(SUM(announced_pu_results.party_score), 0) AS total_result
                            FROM lga
                            LEFT JOIN polling_unit ON polling_unit.lga_id = lga.uniqueid
                            LEFT JOIN announced_pu_results ON announced_pu_results.polling_unit_uniqueid = polling_unit.uniqueid
                            WHERE lga.uniqueid = :localGovernmentID
                            GROUP BY lga.uniqueid");
    $stmt->bindParam(':localGovernmentID', $localGovernmentID);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch local governments
    $stmt = $conn->prepare("SELECT * FROM lga");
    $stmt->execute();
    $localGovernments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize variables
    $selectedLocalGovernmentID = null;
    $result = null;

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $selectedLocalGovernmentID = $_POST['local_government_id'];
        $result = getSummedTotalResult($conn, $selectedLocalGovernmentID);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>InecPublicV2</title>
    <base href="/" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <style type="text/css">
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 300;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fCRc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
          U+A640-A69F, U+FE2E-FE2F;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 300;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fABc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 300;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fCBc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+1F00-1FFF;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 300;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fBxc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0370-03FF;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 300;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fCxc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169,
          U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 300;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fChc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0100-02AF, U+1E00-1EFF, U+2020, U+20A0-20AB,
          U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 300;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmSU5fBBc4AMP6lQ.woff2)
          format("woff2");
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
          U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193,
          U+2212, U+2215, U+FEFF, U+FFFD;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu72xKKTU1Kvnz.woff2)
          format("woff2");
        unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
          U+A640-A69F, U+FE2E-FE2F;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu5mxKKTU1Kvnz.woff2)
          format("woff2");
        unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu7mxKKTU1Kvnz.woff2)
          format("woff2");
        unicode-range: U+1F00-1FFF;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4WxKKTU1Kvnz.woff2)
          format("woff2");
        unicode-range: U+0370-03FF;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu7WxKKTU1Kvnz.woff2)
          format("woff2");
        unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169,
          U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu7GxKKTU1Kvnz.woff2)
          format("woff2");
        unicode-range: U+0100-02AF, U+1E00-1EFF, U+2020, U+20A0-20AB,
          U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 400;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOmCnqEu92Fr1Mu4mxKKTU1Kg.woff2)
          format("woff2");
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
          U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193,
          U+2212, U+2215, U+FEFF, U+FFFD;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 500;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fCRc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF,
          U+A640-A69F, U+FE2E-FE2F;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 500;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fABc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 500;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fCBc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+1F00-1FFF;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 500;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fBxc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0370-03FF;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 500;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fCxc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169,
          U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 500;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fChc4AMP6lbBP.woff2)
          format("woff2");
        unicode-range: U+0100-02AF, U+1E00-1EFF, U+2020, U+20A0-20AB,
          U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
      }
      @font-face {
        font-family: "Roboto";
        font-style: normal;
        font-weight: 500;
        font-display: swap;
        src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fBBc4AMP6lQ.woff2)
          format("woff2");
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6,
          U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193,
          U+2212, U+2215, U+FEFF, U+FFFD;
      }
    </style>
    <style type="text/css">
      @font-face {
        font-family: "Material Icons";
        font-style: normal;
        font-weight: 400;
        src: url(https://fonts.gstatic.com/s/materialicons/v140/flUhRq6tzZclQEJ-Vdg-IuiaDsNcIhQ8tQ.woff2)
          format("woff2");
      }
      .material-icons {
        font-family: "Material Icons";
        font-weight: normal;
        font-style: normal;
        font-size: 24px;
        line-height: 1;
        letter-spacing: normal;
        text-transform: none;
        display: inline-block;
        white-space: nowrap;
        word-wrap: normal;
        direction: ltr;
        -webkit-font-feature-settings: "liga";
        -webkit-font-smoothing: antialiased;
      }
    </style>
    <style>
      :root {
        --fa-font-solid: normal 900 1em/1 "Font Awesome 6 Free";
      }
      @font-face {
        font-family: "Font Awesome 6 Free";
        font-style: normal;
        font-weight: 900;
        font-display: block;
        src: url(fa-solid-900.64d5644d62aa832c.woff2) format("woff2"),
          url(fa-solid-900.f418d876aec0af1a.ttf) format("truetype");
      }
      :root {
        --fa-font-regular: normal 400 1em/1 "Font Awesome 6 Free";
      }
      @font-face {
        font-family: "Font Awesome 6 Free";
        font-style: normal;
        font-weight: 400;
        font-display: block;
        src: url(fa-regular-400.e05509127408c2d4.woff2) format("woff2"),
          url(fa-regular-400.3edb900415298558.ttf) format("truetype");
      }
      .mat-typography {
        font: 400 14px/20px Roboto, Helvetica Neue, sans-serif;
        letter-spacing: normal;
      }
      @charset "UTF-8";
      :root {
        --bs-blue: #0d6efd;
        --bs-indigo: #6610f2;
        --bs-purple: #6f42c1;
        --bs-pink: #d63384;
        --bs-red: #dc3545;
        --bs-orange: #fd7e14;
        --bs-yellow: #ffc107;
        --bs-green: #004f00;
        --bs-teal: #20c997;
        --bs-cyan: #0dcaf0;
        --bs-black: #000;
        --bs-white: #fff;
        --bs-gray: #6c757d;
        --bs-gray-dark: #343a40;
        --bs-gray-100: #f8f9fa;
        --bs-gray-200: #e9ecef;
        --bs-gray-300: #dee2e6;
        --bs-gray-400: #ced4da;
        --bs-gray-500: #adb5bd;
        --bs-gray-600: #6c757d;
        --bs-gray-700: #495057;
        --bs-gray-800: #343a40;
        --bs-gray-900: #212529;
        --bs-primary: #004f00;
        --bs-secondary: #6c757d;
        --bs-success: #004f00;
        --bs-info: #0dcaf0;
        --bs-warning: #ffc107;
        --bs-danger: #dc3545;
        --bs-light: #f8f9fa;
        --bs-dark: #212529;
        --bs-primary-rgb: 0, 79, 0;
        --bs-secondary-rgb: 108, 117, 125;
        --bs-success-rgb: 0, 79, 0;
        --bs-info-rgb: 13, 202, 240;
        --bs-warning-rgb: 255, 193, 7;
        --bs-danger-rgb: 220, 53, 69;
        --bs-light-rgb: 248, 249, 250;
        --bs-dark-rgb: 33, 37, 41;
        --bs-white-rgb: 255, 255, 255;
        --bs-black-rgb: 0, 0, 0;
        --bs-body-color-rgb: 33, 37, 41;
        --bs-body-bg-rgb: 255, 255, 255;
        --bs-font-sans-serif: system-ui, -apple-system, "Segoe UI", Roboto,
          "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif,
          "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol",
          "Noto Color Emoji";
        --bs-font-monospace: SFMono-Regular, Menlo, Monaco, Consolas,
          "Liberation Mono", "Courier New", monospace;
        --bs-gradient: linear-gradient(
          180deg,
          rgba(255, 255, 255, 0.15),
          rgba(255, 255, 255, 0)
        );
        --bs-body-font-family: var(--bs-font-sans-serif);
        --bs-body-font-size: 1rem;
        --bs-body-font-weight: 400;
        --bs-body-line-height: 1.5;
        --bs-body-color: #212529;
        --bs-body-bg: #fff;
        --bs-border-width: 1px;
        --bs-border-style: solid;
        --bs-border-color: #dee2e6;
        --bs-border-color-translucent: rgba(0, 0, 0, 0.175);
        --bs-border-radius: 0.375rem;
        --bs-border-radius-sm: 0.25rem;
        --bs-border-radius-lg: 0.5rem;
        --bs-border-radius-xl: 1rem;
        --bs-border-radius-2xl: 2rem;
        --bs-border-radius-pill: 50rem;
        --bs-link-color: #004f00;
        --bs-link-hover-color: #003f00;
        --bs-code-color: #d63384;
        --bs-highlight-bg: #fff3cd;
      }
      *,
      *:before,
      *:after {
        box-sizing: border-box;
      }
      @media (prefers-reduced-motion: no-preference) {
        :root {
          scroll-behavior: smooth;
        }
      }
      body {
        margin: 0;
        font-family: var(--bs-body-font-family);
        font-size: var(--bs-body-font-size);
        font-weight: var(--bs-body-font-weight);
        line-height: var(--bs-body-line-height);
        color: var(--bs-body-color);
        text-align: var(--bs-body-text-align);
        background-color: var(--bs-body-bg);
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
      }
      body {
        background-color: #f0f0f0;
      }
      html,
      body {
        height: 100%;
      }
      body {
        margin: 0;
        font-family: Roboto, Helvetica Neue, sans-serif;
      }
    </style>
    <link
      rel="stylesheet"
      href="assets/styles.dd7d6b0bcefba256.css"
      media="all"
      onload="this.media='all'"
    />
    <noscript
      ><link rel="stylesheet" href="assets/styles.dd7d6b0bcefba256.css"
    /></noscript>
    <style>
      .swal2-popup.swal2-toast {
        box-sizing: border-box;
        grid-column: 1/4 !important;
        grid-row: 1/4 !important;
        grid-template-columns: 1fr 99fr 1fr;
        padding: 1em;
        overflow-y: hidden;
        background: #fff;
        box-shadow: 0 0 1px hsla(0deg, 0%, 0%, 0.075),
          0 1px 2px hsla(0deg, 0%, 0%, 0.075),
          1px 2px 4px hsla(0deg, 0%, 0%, 0.075),
          1px 3px 8px hsla(0deg, 0%, 0%, 0.075),
          2px 4px 16px hsla(0deg, 0%, 0%, 0.075);
        pointer-events: all;
      }
      .swal2-popup.swal2-toast > * {
        grid-column: 2;
      }
      .swal2-popup.swal2-toast .swal2-title {
        margin: 0.5em 1em;
        padding: 0;
        font-size: 1em;
        text-align: initial;
      }
      .swal2-popup.swal2-toast .swal2-loading {
        justify-content: center;
      }
      .swal2-popup.swal2-toast .swal2-input {
        height: 2em;
        margin: 0.5em;
        font-size: 1em;
      }
      .swal2-popup.swal2-toast .swal2-validation-message {
        font-size: 1em;
      }
      .swal2-popup.swal2-toast .swal2-footer {
        margin: 0.5em 0 0;
        padding: 0.5em 0 0;
        font-size: 0.8em;
      }
      .swal2-popup.swal2-toast .swal2-close {
        grid-column: 3/3;
        grid-row: 1/99;
        align-self: center;
        width: 0.8em;
        height: 0.8em;
        margin: 0;
        font-size: 2em;
      }
      .swal2-popup.swal2-toast .swal2-html-container {
        margin: 0.5em 1em;
        padding: 0;
        overflow: initial;
        font-size: 1em;
        text-align: initial;
      }
      .swal2-popup.swal2-toast .swal2-html-container:empty {
        padding: 0;
      }
      .swal2-popup.swal2-toast .swal2-loader {
        grid-column: 1;
        grid-row: 1/99;
        align-self: center;
        width: 2em;
        height: 2em;
        margin: 0.25em;
      }
      .swal2-popup.swal2-toast .swal2-icon {
        grid-column: 1;
        grid-row: 1/99;
        align-self: center;
        width: 2em;
        min-width: 2em;
        height: 2em;
        margin: 0 0.5em 0 0;
      }
      .swal2-popup.swal2-toast .swal2-icon .swal2-icon-content {
        display: flex;
        align-items: center;
        font-size: 1.8em;
        font-weight: 700;
      }
      .swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring {
        width: 2em;
        height: 2em;
      }
      .swal2-popup.swal2-toast
        .swal2-icon.swal2-error
        [class^="swal2-x-mark-line"] {
        top: 0.875em;
        width: 1.375em;
      }
      .swal2-popup.swal2-toast
        .swal2-icon.swal2-error
        [class^="swal2-x-mark-line"][class$="left"] {
        left: 0.3125em;
      }
      .swal2-popup.swal2-toast
        .swal2-icon.swal2-error
        [class^="swal2-x-mark-line"][class$="right"] {
        right: 0.3125em;
      }
      .swal2-popup.swal2-toast .swal2-actions {
        justify-content: flex-start;
        height: auto;
        margin: 0;
        margin-top: 0.5em;
        padding: 0 0.5em;
      }
      .swal2-popup.swal2-toast .swal2-styled {
        margin: 0.25em 0.5em;
        padding: 0.4em 0.6em;
        font-size: 1em;
      }
      .swal2-popup.swal2-toast .swal2-success {
        border-color: #a5dc86;
      }
      .swal2-popup.swal2-toast
        .swal2-success
        [class^="swal2-success-circular-line"] {
        position: absolute;
        width: 1.6em;
        height: 3em;
        transform: rotate(45deg);
        border-radius: 50%;
      }
      .swal2-popup.swal2-toast
        .swal2-success
        [class^="swal2-success-circular-line"][class$="left"] {
        top: -0.8em;
        left: -0.5em;
        transform: rotate(-45deg);
        transform-origin: 2em 2em;
        border-radius: 4em 0 0 4em;
      }
      .swal2-popup.swal2-toast
        .swal2-success
        [class^="swal2-success-circular-line"][class$="right"] {
        top: -0.25em;
        left: 0.9375em;
        transform-origin: 0 1.5em;
        border-radius: 0 4em 4em 0;
      }
      .swal2-popup.swal2-toast .swal2-success .swal2-success-ring {
        width: 2em;
        height: 2em;
      }
      .swal2-popup.swal2-toast .swal2-success .swal2-success-fix {
        top: 0;
        left: 0.4375em;
        width: 0.4375em;
        height: 2.6875em;
      }
      .swal2-popup.swal2-toast .swal2-success [class^="swal2-success-line"] {
        height: 0.3125em;
      }
      .swal2-popup.swal2-toast
        .swal2-success
        [class^="swal2-success-line"][class$="tip"] {
        top: 1.125em;
        left: 0.1875em;
        width: 0.75em;
      }
      .swal2-popup.swal2-toast
        .swal2-success
        [class^="swal2-success-line"][class$="long"] {
        top: 0.9375em;
        right: 0.1875em;
        width: 1.375em;
      }
      .swal2-popup.swal2-toast
        .swal2-success.swal2-icon-show
        .swal2-success-line-tip {
        -webkit-animation: swal2-toast-animate-success-line-tip 0.75s;
        animation: swal2-toast-animate-success-line-tip 0.75s;
      }
      .swal2-popup.swal2-toast
        .swal2-success.swal2-icon-show
        .swal2-success-line-long {
        -webkit-animation: swal2-toast-animate-success-line-long 0.75s;
        animation: swal2-toast-animate-success-line-long 0.75s;
      }
      .swal2-popup.swal2-toast.swal2-show {
        -webkit-animation: swal2-toast-show 0.5s;
        animation: swal2-toast-show 0.5s;
      }
      .swal2-popup.swal2-toast.swal2-hide {
        -webkit-animation: swal2-toast-hide 0.1s forwards;
        animation: swal2-toast-hide 0.1s forwards;
      }
      .swal2-container {
        display: grid;
        position: fixed;
        z-index: 1060;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        box-sizing: border-box;
        grid-template-areas: "top-start     top            top-end" "center-start  center         center-end" "bottom-start  bottom-center  bottom-end";
        grid-template-rows: minmax(-webkit-min-content, auto) minmax(
            -webkit-min-content,
            auto
          ) minmax(-webkit-min-content, auto);
        grid-template-rows: minmax(min-content, auto) minmax(min-content, auto) minmax(
            min-content,
            auto
          );
        height: 100%;
        padding: 0.625em;
        overflow-x: hidden;
        transition: background-color 0.1s;
        -webkit-overflow-scrolling: touch;
      }
      .swal2-container.swal2-backdrop-show,
      .swal2-container.swal2-noanimation {
        background: rgba(0, 0, 0, 0.4);
      }
      .swal2-container.swal2-backdrop-hide {
        background: 0 0 !important;
      }
      .swal2-container.swal2-bottom-start,
      .swal2-container.swal2-center-start,
      .swal2-container.swal2-top-start {
        grid-template-columns: minmax(0, 1fr) auto auto;
      }
      .swal2-container.swal2-bottom,
      .swal2-container.swal2-center,
      .swal2-container.swal2-top {
        grid-template-columns: auto minmax(0, 1fr) auto;
      }
      .swal2-container.swal2-bottom-end,
      .swal2-container.swal2-center-end,
      .swal2-container.swal2-top-end {
        grid-template-columns: auto auto minmax(0, 1fr);
      }
      .swal2-container.swal2-top-start > .swal2-popup {
        align-self: start;
      }
      .swal2-container.swal2-top > .swal2-popup {
        grid-column: 2;
        align-self: start;
        justify-self: center;
      }
      .swal2-container.swal2-top-end > .swal2-popup,
      .swal2-container.swal2-top-right > .swal2-popup {
        grid-column: 3;
        align-self: start;
        justify-self: end;
      }
      .swal2-container.swal2-center-left > .swal2-popup,
      .swal2-container.swal2-center-start > .swal2-popup {
        grid-row: 2;
        align-self: center;
      }
      .swal2-container.swal2-center > .swal2-popup {
        grid-column: 2;
        grid-row: 2;
        align-self: center;
        justify-self: center;
      }
      .swal2-container.swal2-center-end > .swal2-popup,
      .swal2-container.swal2-center-right > .swal2-popup {
        grid-column: 3;
        grid-row: 2;
        align-self: center;
        justify-self: end;
      }
      .swal2-container.swal2-bottom-left > .swal2-popup,
      .swal2-container.swal2-bottom-start > .swal2-popup {
        grid-column: 1;
        grid-row: 3;
        align-self: end;
      }
      .swal2-container.swal2-bottom > .swal2-popup {
        grid-column: 2;
        grid-row: 3;
        justify-self: center;
        align-self: end;
      }
      .swal2-container.swal2-bottom-end > .swal2-popup,
      .swal2-container.swal2-bottom-right > .swal2-popup {
        grid-column: 3;
        grid-row: 3;
        align-self: end;
        justify-self: end;
      }
      .swal2-container.swal2-grow-fullscreen > .swal2-popup,
      .swal2-container.swal2-grow-row > .swal2-popup {
        grid-column: 1/4;
        width: 100%;
      }
      .swal2-container.swal2-grow-column > .swal2-popup,
      .swal2-container.swal2-grow-fullscreen > .swal2-popup {
        grid-row: 1/4;
        align-self: stretch;
      }
      .swal2-container.swal2-no-transition {
        transition: none !important;
      }
      .swal2-popup {
        display: none;
        position: relative;
        box-sizing: border-box;
        grid-template-columns: minmax(0, 100%);
        width: 32em;
        max-width: 100%;
        padding: 0 0 1.25em;
        border: none;
        border-radius: 5px;
        background: #fff;
        color: #545454;
        font-family: inherit;
        font-size: 1rem;
      }
      .swal2-popup:focus {
        outline: 0;
      }
      .swal2-popup.swal2-loading {
        overflow-y: hidden;
      }
      .swal2-title {
        position: relative;
        max-width: 100%;
        margin: 0;
        padding: 0.8em 1em 0;
        color: inherit;
        font-size: 1.875em;
        font-weight: 600;
        text-align: center;
        text-transform: none;
        word-wrap: break-word;
      }
      .swal2-actions {
        display: flex;
        z-index: 1;
        box-sizing: border-box;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        width: auto;
        margin: 1.25em auto 0;
        padding: 0;
      }
      .swal2-actions:not(.swal2-loading) .swal2-styled[disabled] {
        opacity: 0.4;
      }
      .swal2-actions:not(.swal2-loading) .swal2-styled:hover {
        background-image: linear-gradient(
          rgba(0, 0, 0, 0.1),
          rgba(0, 0, 0, 0.1)
        );
      }
      .swal2-actions:not(.swal2-loading) .swal2-styled:active {
        background-image: linear-gradient(
          rgba(0, 0, 0, 0.2),
          rgba(0, 0, 0, 0.2)
        );
      }
      .swal2-loader {
        display: none;
        align-items: center;
        justify-content: center;
        width: 2.2em;
        height: 2.2em;
        margin: 0 1.875em;
        -webkit-animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
        animation: swal2-rotate-loading 1.5s linear 0s infinite normal;
        border-width: 0.25em;
        border-style: solid;
        border-radius: 100%;
        border-color: #2778c4 transparent #2778c4 transparent;
      }
      .swal2-styled {
        margin: 0.3125em;
        padding: 0.625em 1.1em;
        transition: box-shadow 0.1s;
        box-shadow: 0 0 0 3px transparent;
        font-weight: 500;
      }
      .swal2-styled:not([disabled]) {
        cursor: pointer;
      }
      .swal2-styled.swal2-confirm {
        border: 0;
        border-radius: 0.25em;
        background: initial;
        background-color: #7066e0;
        color: #fff;
        font-size: 1em;
      }
      .swal2-styled.swal2-confirm:focus {
        box-shadow: 0 0 0 3px rgba(112, 102, 224, 0.5);
      }
      .swal2-styled.swal2-deny {
        border: 0;
        border-radius: 0.25em;
        background: initial;
        background-color: #dc3741;
        color: #fff;
        font-size: 1em;
      }
      .swal2-styled.swal2-deny:focus {
        box-shadow: 0 0 0 3px rgba(220, 55, 65, 0.5);
      }
      .swal2-styled.swal2-cancel {
        border: 0;
        border-radius: 0.25em;
        background: initial;
        background-color: #6e7881;
        color: #fff;
        font-size: 1em;
      }
      .swal2-styled.swal2-cancel:focus {
        box-shadow: 0 0 0 3px rgba(110, 120, 129, 0.5);
      }
      .swal2-styled.swal2-default-outline:focus {
        box-shadow: 0 0 0 3px rgba(100, 150, 200, 0.5);
      }
      .swal2-styled:focus {
        outline: 0;
      }
      .swal2-styled::-moz-focus-inner {
        border: 0;
      }
      .swal2-footer {
        justify-content: center;
        margin: 1em 0 0;
        padding: 1em 1em 0;
        border-top: 1px solid #eee;
        color: inherit;
        font-size: 1em;
      }
      .swal2-timer-progress-bar-container {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        grid-column: auto !important;
        overflow: hidden;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
      }
      .swal2-timer-progress-bar {
        width: 100%;
        height: 0.25em;
        background: rgba(0, 0, 0, 0.2);
      }
      .swal2-image {
        max-width: 100%;
        margin: 2em auto 1em;
      }
      .swal2-close {
        z-index: 2;
        align-items: center;
        justify-content: center;
        width: 1.2em;
        height: 1.2em;
        margin-top: 0;
        margin-right: 0;
        margin-bottom: -1.2em;
        padding: 0;
        overflow: hidden;
        transition: color 0.1s, box-shadow 0.1s;
        border: none;
        border-radius: 5px;
        background: 0 0;
        color: #ccc;
        font-family: serif;
        font-family: monospace;
        font-size: 2.5em;
        cursor: pointer;
        justify-self: end;
      }
      .swal2-close:hover {
        transform: none;
        background: 0 0;
        color: #f27474;
      }
      .swal2-close:focus {
        outline: 0;
        box-shadow: inset 0 0 0 3px rgba(100, 150, 200, 0.5);
      }
      .swal2-close::-moz-focus-inner {
        border: 0;
      }
      .swal2-html-container {
        z-index: 1;
        justify-content: center;
        margin: 1em 1.6em 0.3em;
        padding: 0;
        overflow: auto;
        color: inherit;
        font-size: 1.125em;
        font-weight: 400;
        line-height: normal;
        text-align: center;
        word-wrap: break-word;
        word-break: break-word;
      }
      .swal2-checkbox,
      .swal2-file,
      .swal2-input,
      .swal2-radio,
      .swal2-select,
      .swal2-textarea {
        margin: 1em 2em 3px;
      }
      .swal2-file,
      .swal2-input,
      .swal2-textarea {
        box-sizing: border-box;
        width: auto;
        transition: border-color 0.1s, box-shadow 0.1s;
        border: 1px solid #d9d9d9;
        border-radius: 0.1875em;
        background: 0 0;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.06), 0 0 0 3px transparent;
        color: inherit;
        font-size: 1.125em;
      }
      .swal2-file.swal2-inputerror,
      .swal2-input.swal2-inputerror,
      .swal2-textarea.swal2-inputerror {
        border-color: #f27474 !important;
        box-shadow: 0 0 2px #f27474 !important;
      }
      .swal2-file:focus,
      .swal2-input:focus,
      .swal2-textarea:focus {
        border: 1px solid #b4dbed;
        outline: 0;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.06),
          0 0 0 3px rgba(100, 150, 200, 0.5);
      }
      .swal2-file::-moz-placeholder,
      .swal2-input::-moz-placeholder,
      .swal2-textarea::-moz-placeholder {
        color: #ccc;
      }
      .swal2-file::placeholder,
      .swal2-input::placeholder,
      .swal2-textarea::placeholder {
        color: #ccc;
      }
      .swal2-range {
        margin: 1em 2em 3px;
        background: #fff;
      }
      .swal2-range input {
        width: 80%;
      }
      .swal2-range output {
        width: 20%;
        color: inherit;
        font-weight: 600;
        text-align: center;
      }
      .swal2-range input,
      .swal2-range output {
        height: 2.625em;
        padding: 0;
        font-size: 1.125em;
        line-height: 2.625em;
      }
      .swal2-input {
        height: 2.625em;
        padding: 0 0.75em;
      }
      .swal2-file {
        width: 75%;
        margin-right: auto;
        margin-left: auto;
        background: 0 0;
        font-size: 1.125em;
      }
      .swal2-textarea {
        height: 6.75em;
        padding: 0.75em;
      }
      .swal2-select {
        min-width: 50%;
        max-width: 100%;
        padding: 0.375em 0.625em;
        background: 0 0;
        color: inherit;
        font-size: 1.125em;
      }
      .swal2-checkbox,
      .swal2-radio {
        align-items: center;
        justify-content: center;
        background: #fff;
        color: inherit;
      }
      .swal2-checkbox label,
      .swal2-radio label {
        margin: 0 0.6em;
        font-size: 1.125em;
      }
      .swal2-checkbox input,
      .swal2-radio input {
        flex-shrink: 0;
        margin: 0 0.4em;
      }
      .swal2-input-label {
        display: flex;
        justify-content: center;
        margin: 1em auto 0;
      }
      .swal2-validation-message {
        align-items: center;
        justify-content: center;
        margin: 1em 0 0;
        padding: 0.625em;
        overflow: hidden;
        background: #f0f0f0;
        color: #666;
        font-size: 1em;
        font-weight: 300;
      }
      .swal2-validation-message::before {
        content: "!";
        display: inline-block;
        width: 1.5em;
        min-width: 1.5em;
        height: 1.5em;
        margin: 0 0.625em;
        border-radius: 50%;
        background-color: #f27474;
        color: #fff;
        font-weight: 600;
        line-height: 1.5em;
        text-align: center;
      }
      .swal2-icon {
        position: relative;
        box-sizing: content-box;
        justify-content: center;
        width: 5em;
        height: 5em;
        margin: 2.5em auto 0.6em;
        border: 0.25em solid transparent;
        border-radius: 50%;
        border-color: #000;
        font-family: inherit;
        line-height: 5em;
        cursor: default;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      .swal2-icon .swal2-icon-content {
        display: flex;
        align-items: center;
        font-size: 3.75em;
      }
      .swal2-icon.swal2-error {
        border-color: #f27474;
        color: #f27474;
      }
      .swal2-icon.swal2-error .swal2-x-mark {
        position: relative;
        flex-grow: 1;
      }
      .swal2-icon.swal2-error [class^="swal2-x-mark-line"] {
        display: block;
        position: absolute;
        top: 2.3125em;
        width: 2.9375em;
        height: 0.3125em;
        border-radius: 0.125em;
        background-color: #f27474;
      }
      .swal2-icon.swal2-error [class^="swal2-x-mark-line"][class$="left"] {
        left: 1.0625em;
        transform: rotate(45deg);
      }
      .swal2-icon.swal2-error [class^="swal2-x-mark-line"][class$="right"] {
        right: 1em;
        transform: rotate(-45deg);
      }
      .swal2-icon.swal2-error.swal2-icon-show {
        -webkit-animation: swal2-animate-error-icon 0.5s;
        animation: swal2-animate-error-icon 0.5s;
      }
      .swal2-icon.swal2-error.swal2-icon-show .swal2-x-mark {
        -webkit-animation: swal2-animate-error-x-mark 0.5s;
        animation: swal2-animate-error-x-mark 0.5s;
      }
      .swal2-icon.swal2-warning {
        border-color: #facea8;
        color: #f8bb86;
      }
      .swal2-icon.swal2-warning.swal2-icon-show {
        -webkit-animation: swal2-animate-error-icon 0.5s;
        animation: swal2-animate-error-icon 0.5s;
      }
      .swal2-icon.swal2-warning.swal2-icon-show .swal2-icon-content {
        -webkit-animation: swal2-animate-i-mark 0.5s;
        animation: swal2-animate-i-mark 0.5s;
      }
      .swal2-icon.swal2-info {
        border-color: #9de0f6;
        color: #3fc3ee;
      }
      .swal2-icon.swal2-info.swal2-icon-show {
        -webkit-animation: swal2-animate-error-icon 0.5s;
        animation: swal2-animate-error-icon 0.5s;
      }
      .swal2-icon.swal2-info.swal2-icon-show .swal2-icon-content {
        -webkit-animation: swal2-animate-i-mark 0.8s;
        animation: swal2-animate-i-mark 0.8s;
      }
      .swal2-icon.swal2-question {
        border-color: #c9dae1;
        color: #87adbd;
      }
      .swal2-icon.swal2-question.swal2-icon-show {
        -webkit-animation: swal2-animate-error-icon 0.5s;
        animation: swal2-animate-error-icon 0.5s;
      }
      .swal2-icon.swal2-question.swal2-icon-show .swal2-icon-content {
        -webkit-animation: swal2-animate-question-mark 0.8s;
        animation: swal2-animate-question-mark 0.8s;
      }
      .swal2-icon.swal2-success {
        border-color: #a5dc86;
        color: #a5dc86;
      }
      .swal2-icon.swal2-success [class^="swal2-success-circular-line"] {
        position: absolute;
        width: 3.75em;
        height: 7.5em;
        transform: rotate(45deg);
        border-radius: 50%;
      }
      .swal2-icon.swal2-success
        [class^="swal2-success-circular-line"][class$="left"] {
        top: -0.4375em;
        left: -2.0635em;
        transform: rotate(-45deg);
        transform-origin: 3.75em 3.75em;
        border-radius: 7.5em 0 0 7.5em;
      }
      .swal2-icon.swal2-success
        [class^="swal2-success-circular-line"][class$="right"] {
        top: -0.6875em;
        left: 1.875em;
        transform: rotate(-45deg);
        transform-origin: 0 3.75em;
        border-radius: 0 7.5em 7.5em 0;
      }
      .swal2-icon.swal2-success .swal2-success-ring {
        position: absolute;
        z-index: 2;
        top: -0.25em;
        left: -0.25em;
        box-sizing: content-box;
        width: 100%;
        height: 100%;
        border: 0.25em solid rgba(165, 220, 134, 0.3);
        border-radius: 50%;
      }
      .swal2-icon.swal2-success .swal2-success-fix {
        position: absolute;
        z-index: 1;
        top: 0.5em;
        left: 1.625em;
        width: 0.4375em;
        height: 5.625em;
        transform: rotate(-45deg);
      }
      .swal2-icon.swal2-success [class^="swal2-success-line"] {
        display: block;
        position: absolute;
        z-index: 2;
        height: 0.3125em;
        border-radius: 0.125em;
        background-color: #a5dc86;
      }
      .swal2-icon.swal2-success [class^="swal2-success-line"][class$="tip"] {
        top: 2.875em;
        left: 0.8125em;
        width: 1.5625em;
        transform: rotate(45deg);
      }
      .swal2-icon.swal2-success [class^="swal2-success-line"][class$="long"] {
        top: 2.375em;
        right: 0.5em;
        width: 2.9375em;
        transform: rotate(-45deg);
      }
      .swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-tip {
        -webkit-animation: swal2-animate-success-line-tip 0.75s;
        animation: swal2-animate-success-line-tip 0.75s;
      }
      .swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-long {
        -webkit-animation: swal2-animate-success-line-long 0.75s;
        animation: swal2-animate-success-line-long 0.75s;
      }
      .swal2-icon.swal2-success.swal2-icon-show
        .swal2-success-circular-line-right {
        -webkit-animation: swal2-rotate-success-circular-line 4.25s ease-in;
        animation: swal2-rotate-success-circular-line 4.25s ease-in;
      }
      .swal2-progress-steps {
        flex-wrap: wrap;
        align-items: center;
        max-width: 100%;
        margin: 1.25em auto;
        padding: 0;
        background: 0 0;
        font-weight: 600;
      }
      .swal2-progress-steps li {
        display: inline-block;
        position: relative;
      }
      .swal2-progress-steps .swal2-progress-step {
        z-index: 20;
        flex-shrink: 0;
        width: 2em;
        height: 2em;
        border-radius: 2em;
        background: #2778c4;
        color: #fff;
        line-height: 2em;
        text-align: center;
      }
      .swal2-progress-steps .swal2-progress-step.swal2-active-progress-step {
        background: #2778c4;
      }
      .swal2-progress-steps
        .swal2-progress-step.swal2-active-progress-step
        ~ .swal2-progress-step {
        background: #add8e6;
        color: #fff;
      }
      .swal2-progress-steps
        .swal2-progress-step.swal2-active-progress-step
        ~ .swal2-progress-step-line {
        background: #add8e6;
      }
      .swal2-progress-steps .swal2-progress-step-line {
        z-index: 10;
        flex-shrink: 0;
        width: 2.5em;
        height: 0.4em;
        margin: 0 -1px;
        background: #2778c4;
      }
      [class^="swal2"] {
        -webkit-tap-highlight-color: transparent;
      }
      .swal2-show {
        -webkit-animation: swal2-show 0.3s;
        animation: swal2-show 0.3s;
      }
      .swal2-hide {
        -webkit-animation: swal2-hide 0.15s forwards;
        animation: swal2-hide 0.15s forwards;
      }
      .swal2-noanimation {
        transition: none;
      }
      .swal2-scrollbar-measure {
        position: absolute;
        top: -9999px;
        width: 50px;
        height: 50px;
        overflow: scroll;
      }
      .swal2-rtl .swal2-close {
        margin-right: initial;
        margin-left: 0;
      }
      .swal2-rtl .swal2-timer-progress-bar {
        right: 0;
        left: auto;
      }
      .leave-russia-now-and-apply-your-skills-to-the-world {
        display: flex;
        position: fixed;
        z-index: 1939;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 0 20px;
        background: #20232a;
        color: #fff;
        text-align: center;
      }
      .leave-russia-now-and-apply-your-skills-to-the-world div {
        max-width: 560px;
        margin: 10px;
        line-height: 146%;
      }
      .leave-russia-now-and-apply-your-skills-to-the-world iframe {
        max-width: 100%;
        max-height: 55.5555555556vmin;
        margin: 16px auto;
      }
      .leave-russia-now-and-apply-your-skills-to-the-world strong {
        border-bottom: 2px dashed #fff;
      }
      .leave-russia-now-and-apply-your-skills-to-the-world button {
        display: flex;
        position: fixed;
        z-index: 1940;
        top: 0;
        right: 0;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        margin-right: 10px;
        margin-bottom: -10px;
        border: none;
        background: 0 0;
        color: #aaa;
        font-size: 48px;
        font-weight: 700;
        cursor: pointer;
      }
      .leave-russia-now-and-apply-your-skills-to-the-world button:hover {
        color: #fff;
      }
      @-webkit-keyframes swal2-toast-show {
        0% {
          transform: translateY(-0.625em) rotateZ(2deg);
        }
        33% {
          transform: translateY(0) rotateZ(-2deg);
        }
        66% {
          transform: translateY(0.3125em) rotateZ(2deg);
        }
        100% {
          transform: translateY(0) rotateZ(0);
        }
      }
      @keyframes swal2-toast-show {
        0% {
          transform: translateY(-0.625em) rotateZ(2deg);
        }
        33% {
          transform: translateY(0) rotateZ(-2deg);
        }
        66% {
          transform: translateY(0.3125em) rotateZ(2deg);
        }
        100% {
          transform: translateY(0) rotateZ(0);
        }
      }
      @-webkit-keyframes swal2-toast-hide {
        100% {
          transform: rotateZ(1deg);
          opacity: 0;
        }
      }
      @keyframes swal2-toast-hide {
        100% {
          transform: rotateZ(1deg);
          opacity: 0;
        }
      }
      @-webkit-keyframes swal2-toast-animate-success-line-tip {
        0% {
          top: 0.5625em;
          left: 0.0625em;
          width: 0;
        }
        54% {
          top: 0.125em;
          left: 0.125em;
          width: 0;
        }
        70% {
          top: 0.625em;
          left: -0.25em;
          width: 1.625em;
        }
        84% {
          top: 1.0625em;
          left: 0.75em;
          width: 0.5em;
        }
        100% {
          top: 1.125em;
          left: 0.1875em;
          width: 0.75em;
        }
      }
      @keyframes swal2-toast-animate-success-line-tip {
        0% {
          top: 0.5625em;
          left: 0.0625em;
          width: 0;
        }
        54% {
          top: 0.125em;
          left: 0.125em;
          width: 0;
        }
        70% {
          top: 0.625em;
          left: -0.25em;
          width: 1.625em;
        }
        84% {
          top: 1.0625em;
          left: 0.75em;
          width: 0.5em;
        }
        100% {
          top: 1.125em;
          left: 0.1875em;
          width: 0.75em;
        }
      }
      @-webkit-keyframes swal2-toast-animate-success-line-long {
        0% {
          top: 1.625em;
          right: 1.375em;
          width: 0;
        }
        65% {
          top: 1.25em;
          right: 0.9375em;
          width: 0;
        }
        84% {
          top: 0.9375em;
          right: 0;
          width: 1.125em;
        }
        100% {
          top: 0.9375em;
          right: 0.1875em;
          width: 1.375em;
        }
      }
      @keyframes swal2-toast-animate-success-line-long {
        0% {
          top: 1.625em;
          right: 1.375em;
          width: 0;
        }
        65% {
          top: 1.25em;
          right: 0.9375em;
          width: 0;
        }
        84% {
          top: 0.9375em;
          right: 0;
          width: 1.125em;
        }
        100% {
          top: 0.9375em;
          right: 0.1875em;
          width: 1.375em;
        }
      }
      @-webkit-keyframes swal2-show {
        0% {
          transform: scale(0.7);
        }
        45% {
          transform: scale(1.05);
        }
        80% {
          transform: scale(0.95);
        }
        100% {
          transform: scale(1);
        }
      }
      @keyframes swal2-show {
        0% {
          transform: scale(0.7);
        }
        45% {
          transform: scale(1.05);
        }
        80% {
          transform: scale(0.95);
        }
        100% {
          transform: scale(1);
        }
      }
      @-webkit-keyframes swal2-hide {
        0% {
          transform: scale(1);
          opacity: 1;
        }
        100% {
          transform: scale(0.5);
          opacity: 0;
        }
      }
      @keyframes swal2-hide {
        0% {
          transform: scale(1);
          opacity: 1;
        }
        100% {
          transform: scale(0.5);
          opacity: 0;
        }
      }
      @-webkit-keyframes swal2-animate-success-line-tip {
        0% {
          top: 1.1875em;
          left: 0.0625em;
          width: 0;
        }
        54% {
          top: 1.0625em;
          left: 0.125em;
          width: 0;
        }
        70% {
          top: 2.1875em;
          left: -0.375em;
          width: 3.125em;
        }
        84% {
          top: 3em;
          left: 1.3125em;
          width: 1.0625em;
        }
        100% {
          top: 2.8125em;
          left: 0.8125em;
          width: 1.5625em;
        }
      }
      @keyframes swal2-animate-success-line-tip {
        0% {
          top: 1.1875em;
          left: 0.0625em;
          width: 0;
        }
        54% {
          top: 1.0625em;
          left: 0.125em;
          width: 0;
        }
        70% {
          top: 2.1875em;
          left: -0.375em;
          width: 3.125em;
        }
        84% {
          top: 3em;
          left: 1.3125em;
          width: 1.0625em;
        }
        100% {
          top: 2.8125em;
          left: 0.8125em;
          width: 1.5625em;
        }
      }
      @-webkit-keyframes swal2-animate-success-line-long {
        0% {
          top: 3.375em;
          right: 2.875em;
          width: 0;
        }
        65% {
          top: 3.375em;
          right: 2.875em;
          width: 0;
        }
        84% {
          top: 2.1875em;
          right: 0;
          width: 3.4375em;
        }
        100% {
          top: 2.375em;
          right: 0.5em;
          width: 2.9375em;
        }
      }
      @keyframes swal2-animate-success-line-long {
        0% {
          top: 3.375em;
          right: 2.875em;
          width: 0;
        }
        65% {
          top: 3.375em;
          right: 2.875em;
          width: 0;
        }
        84% {
          top: 2.1875em;
          right: 0;
          width: 3.4375em;
        }
        100% {
          top: 2.375em;
          right: 0.5em;
          width: 2.9375em;
        }
      }
      @-webkit-keyframes swal2-rotate-success-circular-line {
        0% {
          transform: rotate(-45deg);
        }
        5% {
          transform: rotate(-45deg);
        }
        12% {
          transform: rotate(-405deg);
        }
        100% {
          transform: rotate(-405deg);
        }
      }
      @keyframes swal2-rotate-success-circular-line {
        0% {
          transform: rotate(-45deg);
        }
        5% {
          transform: rotate(-45deg);
        }
        12% {
          transform: rotate(-405deg);
        }
        100% {
          transform: rotate(-405deg);
        }
      }
      @-webkit-keyframes swal2-animate-error-x-mark {
        0% {
          margin-top: 1.625em;
          transform: scale(0.4);
          opacity: 0;
        }
        50% {
          margin-top: 1.625em;
          transform: scale(0.4);
          opacity: 0;
        }
        80% {
          margin-top: -0.375em;
          transform: scale(1.15);
        }
        100% {
          margin-top: 0;
          transform: scale(1);
          opacity: 1;
        }
      }
      @keyframes swal2-animate-error-x-mark {
        0% {
          margin-top: 1.625em;
          transform: scale(0.4);
          opacity: 0;
        }
        50% {
          margin-top: 1.625em;
          transform: scale(0.4);
          opacity: 0;
        }
        80% {
          margin-top: -0.375em;
          transform: scale(1.15);
        }
        100% {
          margin-top: 0;
          transform: scale(1);
          opacity: 1;
        }
      }
      @-webkit-keyframes swal2-animate-error-icon {
        0% {
          transform: rotateX(100deg);
          opacity: 0;
        }
        100% {
          transform: rotateX(0);
          opacity: 1;
        }
      }
      @keyframes swal2-animate-error-icon {
        0% {
          transform: rotateX(100deg);
          opacity: 0;
        }
        100% {
          transform: rotateX(0);
          opacity: 1;
        }
      }
      @-webkit-keyframes swal2-rotate-loading {
        0% {
          transform: rotate(0);
        }
        100% {
          transform: rotate(360deg);
        }
      }
      @keyframes swal2-rotate-loading {
        0% {
          transform: rotate(0);
        }
        100% {
          transform: rotate(360deg);
        }
      }
      @-webkit-keyframes swal2-animate-question-mark {
        0% {
          transform: rotateY(-360deg);
        }
        100% {
          transform: rotateY(0);
        }
      }
      @keyframes swal2-animate-question-mark {
        0% {
          transform: rotateY(-360deg);
        }
        100% {
          transform: rotateY(0);
        }
      }
      @-webkit-keyframes swal2-animate-i-mark {
        0% {
          transform: rotateZ(45deg);
          opacity: 0;
        }
        25% {
          transform: rotateZ(-25deg);
          opacity: 0.4;
        }
        50% {
          transform: rotateZ(15deg);
          opacity: 0.8;
        }
        75% {
          transform: rotateZ(-5deg);
          opacity: 1;
        }
        100% {
          transform: rotateX(0);
          opacity: 1;
        }
      }
      @keyframes swal2-animate-i-mark {
        0% {
          transform: rotateZ(45deg);
          opacity: 0;
        }
        25% {
          transform: rotateZ(-25deg);
          opacity: 0.4;
        }
        50% {
          transform: rotateZ(15deg);
          opacity: 0.8;
        }
        75% {
          transform: rotateZ(-5deg);
          opacity: 1;
        }
        100% {
          transform: rotateX(0);
          opacity: 1;
        }
      }
      body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
        overflow: hidden;
      }
      body.swal2-height-auto {
        height: auto !important;
      }
      body.swal2-no-backdrop .swal2-container {
        background-color: transparent !important;
        pointer-events: none;
      }
      body.swal2-no-backdrop .swal2-container .swal2-popup {
        pointer-events: all;
      }
      body.swal2-no-backdrop .swal2-container .swal2-modal {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
      }
      @media print {
        body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) {
          overflow-y: scroll !important;
        }
        body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)
          > [aria-hidden="true"] {
          display: none;
        }
        body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)
          .swal2-container {
          position: static !important;
        }
      }
      body.swal2-toast-shown .swal2-container {
        box-sizing: border-box;
        width: 360px;
        max-width: 100%;
        background-color: transparent;
        pointer-events: none;
      }
      body.swal2-toast-shown .swal2-container.swal2-top {
        top: 0;
        right: auto;
        bottom: auto;
        left: 50%;
        transform: translateX(-50%);
      }
      body.swal2-toast-shown .swal2-container.swal2-top-end,
      body.swal2-toast-shown .swal2-container.swal2-top-right {
        top: 0;
        right: 0;
        bottom: auto;
        left: auto;
      }
      body.swal2-toast-shown .swal2-container.swal2-top-left,
      body.swal2-toast-shown .swal2-container.swal2-top-start {
        top: 0;
        right: auto;
        bottom: auto;
        left: 0;
      }
      body.swal2-toast-shown .swal2-container.swal2-center-left,
      body.swal2-toast-shown .swal2-container.swal2-center-start {
        top: 50%;
        right: auto;
        bottom: auto;
        left: 0;
        transform: translateY(-50%);
      }
      body.swal2-toast-shown .swal2-container.swal2-center {
        top: 50%;
        right: auto;
        bottom: auto;
        left: 50%;
        transform: translate(-50%, -50%);
      }
      body.swal2-toast-shown .swal2-container.swal2-center-end,
      body.swal2-toast-shown .swal2-container.swal2-center-right {
        top: 50%;
        right: 0;
        bottom: auto;
        left: auto;
        transform: translateY(-50%);
      }
      body.swal2-toast-shown .swal2-container.swal2-bottom-left,
      body.swal2-toast-shown .swal2-container.swal2-bottom-start {
        top: auto;
        right: auto;
        bottom: 0;
        left: 0;
      }
      body.swal2-toast-shown .swal2-container.swal2-bottom {
        top: auto;
        right: auto;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
      }
      body.swal2-toast-shown .swal2-container.swal2-bottom-end,
      body.swal2-toast-shown .swal2-container.swal2-bottom-right {
        top: auto;
        right: 0;
        bottom: 0;
        left: auto;
      }
    </style>
    <style type="text/css"></style>
    <style>
      [_nghost-tja-c44] {
        width: -webkit-fit-content;
        width: -moz-fit-content;
        width: fit-content;
        display: block;
      }
    </style>
    <script
      type="text/javascript"
      src="https://www.gstatic.com/charts/loader.js"
      async=""
    ></script>
    <script
      type="text/javascript"
      charset="UTF-8"
      src="https://www.gstatic.com/charts/51/loader.js"
    ></script>
    <link
      id="load-css-0"
      rel="stylesheet"
      type="text/css"
      href="https://www.gstatic.com/charts/51/css/core/tooltip.css"
    />
    <link
      id="load-css-1"
      rel="stylesheet"
      type="text/css"
      href="https://www.gstatic.com/charts/51/css/util/util.css"
    />
    <script
      type="text/javascript"
      charset="UTF-8"
      src="https://www.gstatic.com/charts/51/js/jsapi_compiled_default_module.js"
    ></script>
    <script
      type="text/javascript"
      charset="UTF-8"
      src="https://www.gstatic.com/charts/51/js/jsapi_compiled_graphics_module.js"
    ></script>
    <script
      type="text/javascript"
      charset="UTF-8"
      src="https://www.gstatic.com/charts/51/js/jsapi_compiled_ui_module.js"
    ></script>
    <script
      type="text/javascript"
      charset="UTF-8"
      src="https://www.gstatic.com/charts/51/js/jsapi_compiled_corechart_module.js"
    ></script>
  </head>
  <body class="mat-typography">
    <app-root _nghost-tja-c64="" ng-version="14.2.0"
      ><div _ngcontent-tja-c64="">
        <router-outlet _ngcontent-tja-c64=""></router-outlet
        ><app-activated _nghost-tja-c13=""
          ><div _ngcontent-tja-c13="">
            <app-navigation _ngcontent-tja-c13="" _nghost-tja-c10=""
              ><header _ngcontent-tja-c10="" class="primary-bg shadow">
                <div _ngcontent-tja-c10="" class="container-fluid p-0">
                  <nav
                    _ngcontent-tja-c10=""
                    class="navbar navbar-expand-lg bg-dark-primary"
                  >
                    <div _ngcontent-tja-c10="" class="container-fluid">
                      <a _ngcontent-tja-c10="" class="navbar-brand"
                        ><img
                          _ngcontent-tja-c10=""
                          class="logo me-5"
                          src="assets/images/logo.png"
                        /><strong _ngcontent-tja-c10="" class="text-white"
                          ><a
                            _ngcontent-tja-c10=""
                            id="home-link"
                            routerlink="/elections"
                            class="home-link"
                            href="/elections"
                            >IREV</a
                          ></strong
                        ></a
                      >
                      <ul
                        _ngcontent-tja-c10=""
                        class="navbar-nav ml-auto nav-flex-icons"
                      >
                        <li _ngcontent-tja-c10="" class="nav-item mr-2">
                          <a
                            _ngcontent-tja-c10=""
                            routerlink="/elections"
                            class="nav-link"
                            href="/elections"
                            ><i
                              _ngcontent-tja-c10=""
                              class="fa-solid fa-search me-2"
                            ></i>
                            Elections</a
                          >
                        </li>
                        <li _ngcontent-tja-c10="" class="nav-item mr-2">
                          <a
                            _ngcontent-tja-c10=""
                            routerlink="/elections/latest"
                            class="nav-link"
                            href="login.html"
                            ><i
                              _ngcontent-tja-c10=""
                              class="fa-solid fa-clock me-2"
                            ></i>
                            Login</a
                          >
                        </li>
                      </ul>
                    </div>
                  </nav>
                </div>
              </header></app-navigation
            >
            <div _ngcontent-tja-c13="">
              <div _ngcontent-tja-c13="">
                <div _ngcontent-tja-c13="" class="mb-5">
                  <div _ngcontent-tja-c13=""></div>
                  <router-outlet _ngcontent-tja-c13=""></router-outlet
                  ><app-election-lga _nghost-tja-c54=""
                    ><div _ngcontent-tja-c54="">
                      <div _ngcontent-tja-c54="">
                        <div
                          _ngcontent-tja-c54=""
                          class="container bg-white mt-5 p-5 rounded"
                        >
                          <div _ngcontent-tja-c54="" class="mb-5">
                            <div _ngcontent-tja-c54="" class="h2 text-primary">
                              Presidential election - 2011-04-26 - Presidential
                            </div>
                            <!---->
                          </div>
                          <div _ngcontent-tja-c54="" class="row">
                            <div
                              _ngcontent-tja-c54=""
                              class="col-md-3 col-sm-12"
                            >
                            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $result): ?>
                              <div _ngcontent-tja-c54="">
                                <app-result-stats
                                  _ngcontent-tja-c54=""
                                  _nghost-tja-c50=""
                                  ><div _ngcontent-tja-c50="">
                                    <div
                                      _ngcontent-tja-c50=""
                                      class="alert alert-secondary shadow-sm"
                                    >
                                      <div _ngcontent-tja-c50="">
                                        <h2 _ngcontent-tja-c50="">
                                        <?php echo $result['lga_name']; ?> Result Stats
                                        </h2>
                                      </div>
                                      <div _ngcontent-tja-c50="">
                                        <div _ngcontent-tja-c50="">
                                          Total submitted results
                                        </div>
                                        <div _ngcontent-tja-c50="">
                                          <h1 _ngcontent-tja-c50=""><?php echo $result['total_result']; ?></h1>
                                          <!----><!---->
                                          <hr _ngcontent-tja-c50="" />
                                          <div _ngcontent-tja-c50="">
                                            Out of <?php echo $result['total_result']; ?>
                                          </div>
                                          <!----><!---->
                                        </div>
                                        <app-loading
                                          _ngcontent-tja-c50=""
                                          _nghost-tja-c29=""
                                          ><!----></app-loading
                                        >
                                      </div>
                                      <hr _ngcontent-tja-c50="" />
                                      
                                        <button
                                          
                                          class="btn btn-light"
                                          type="submit">
                                          
                                          Refresh
                                        </button>
                                    </div>
                                  </div></app-result-stats
                                >
                              </div>
                            <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && !$result): ?>
                              <div _ngcontent-tja-c54="">
                                <app-result-stats
                                  _ngcontent-tja-c54=""
                                  _nghost-tja-c50=""
                                  ><div _ngcontent-tja-c50="">
                                    <div
                                      _ngcontent-tja-c50=""
                                      class="alert alert-secondary shadow-sm"
                                    >
                                      <div _ngcontent-tja-c50="">
                                        <h2 _ngcontent-tja-c50="">
                                          Result Stats
                                        </h2>
                                      </div>
                                      <div _ngcontent-tja-c50="">
                                        <div _ngcontent-tja-c50="">
                                          Total submitted results
                                        </div>
                                        <div _ngcontent-tja-c50="">
                                          <h1 _ngcontent-tja-c50="">0</h1>
                                          <!----><!---->
                                          <hr _ngcontent-tja-c50="" />
                                          <div _ngcontent-tja-c50="">
                                            Out of 0
                                          </div>
                                          <!----><!---->
                                        </div>
                                        <app-loading
                                          _ngcontent-tja-c50=""
                                          _nghost-tja-c29=""
                                          ><!----></app-loading
                                        >
                                      </div>
                                      <hr _ngcontent-tja-c50="" />
                                      <div
                                        _ngcontent-tja-c50=""
                                        class="text-end"
                                      >
                                       
                                      </div>
                                    </div>
                                  </div></app-result-stats
                                >
                              </div>
                            <?php else: ?>
                              <div _ngcontent-tja-c54="">
                              <p>Select a local government and click "Calculate Sum" to view results.</p>
                              </div>
                            <?php endif; ?>
                              <!---->
                            </div>
                            <div _ngcontent-tja-c54="" class="col-md">
                              <div _ngcontent-tja-c54="">
                                <div
                                  _ngcontent-tja-c54=""
                                  class="bg-deep-green"
                                >
                                  <div _ngcontent-tja-c54="">
                                    <div
                                      _ngcontent-tja-c54=""
                                      class="d-flex justify-content-between"
                                    >
                                      <div _ngcontent-tja-c54=""></div>
                                    </div>
                                  </div>
                                </div>
                                <div _ngcontent-tja-c54="">
                                  <div _ngcontent-tja-c54="" class="row">
                                    <div _ngcontent-tja-c54="" class="col-md-7">
                                      <div _ngcontent-tja-c54="">
                                        
                                      </div>
                                      <!---->
                                    </div>
                                  
                                  </div>
                                  <div _ngcontent-tja-c54=""></div>
                                  <app-loading
                                    _ngcontent-tja-c54=""
                                    _nghost-tja-c29=""
                                    ><!----></app-loading
                                  >
                                  <h1>Summed Total Result for All Local Governments</h1>
   
                                  <hr>
                                  <h2>Select Local Government</h2>
                                  <form action="" method="post">
                                      <label for="local_government_id">Select Local Government:</label>
                                      <select name="local_government_id" id="local_government_id">
                                          <?php foreach ($localGovernments as $localGovernment): ?>
                                              <option value="<?php echo $localGovernment['uniqueid']; ?>" <?php if ($localGovernment['uniqueid'] === $selectedLocalGovernmentID) echo 'selected'; ?>><?php echo $localGovernment['lga_name']; ?></option>
                                          <?php endforeach; ?>
                                      </select>
                                      <button type="submit">Calculate Sum</button>
                                  </form>
                                  <!----><!----><!---->
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div></app-election-lga
                  ><!---->
                </div>
                <app-footer _ngcontent-tja-c13="" _nghost-tja-c12=""
                  ><section _ngcontent-tja-c12="" id="footer">
                    <div _ngcontent-tja-c12="" class="container-fluid">
                      <hr _ngcontent-tja-c12="" />
                      <div _ngcontent-tja-c12="" class="row">
                        <div _ngcontent-tja-c12="" class="col-md-2">
                          <img
                            _ngcontent-tja-c12=""
                            src="assets/images/logo.png"
                            class="logo"
                          />
                        </div>
                        <div
                          _ngcontent-tja-c12=""
                          class="col-lg-10 pt-4 text-end"
                        >
                          <div _ngcontent-tja-c12="" class="mr-5">
                            © 2023. INEC. All Rights Reserved.
                          </div>
                        </div>
                      </div>
                    </div>
                  </section></app-footer
                >
              </div>
            </div>
          </div></app-activated
        ><!---->
      </div></app-root
    >
    <script src="assets/js/runtime.5469c3fb8906c889.js" type="module"></script>
    <script src="assets/js/polyfills.0b810bfbf28cbd7f.js" type="module"></script>
    <script src="assets/js/scripts.79aad53d6fc9c5e7.js" defer=""></script>
    <script src="a...ssets/js/main.00088efdf9f691cd.js" type="module"></script>

    <div
      style="
        position: absolute;
        visibility: hidden;
        left: 804px;
        top: 290px;
        display: none;
      "
      class="goog-tooltip"
    >
      <div
        style="
          background: infobackground;
          padding: 1px;
          border: 1px solid infotext;
          font-size: 11px;
          margin: 11px;
          font-family: Arial;
        "
      >
        Expected
      </div>
    </div>
    <div
      class="goog-tooltip"
      style="
        position: absolute;
        visibility: hidden;
        left: 804px;
        top: 314px;
        display: none;
      "
    >
      <div
        style="
          background: infobackground;
          padding: 1px;
          border: 1px solid infotext;
          font-size: 11px;
          margin: 11px;
          font-family: Arial;
        "
      >
        Uploaded
      </div>
    </div>
    <div style="position: absolute; display: none">
      <div
        style="
          background: infobackground;
          padding: 1px;
          border: 1px solid infotext;
          font-size: 11px;
          margin: 11px;
          font-family: Arial;
        "
      >
        Expected
      </div>
    </div>
    <div style="position: absolute; display: none">
      <div
        style="
          background: infobackground;
          padding: 1px;
          border: 1px solid infotext;
          font-size: 11px;
          margin: 11px;
          font-family: Arial;
        "
      >
        Uploaded
      </div>
    </div>
    <div style="position: absolute; display: none">
      <div
        style="
          background: infobackground;
          padding: 1px;
          border: 1px solid infotext;
          font-size: 11px;
          margin: 11px;
          font-family: Arial;
        "
      >
        Expected
      </div>
    </div>
    <div style="position: absolute; display: none">
      <div
        style="
          background: infobackground;
          padding: 1px;
          border: 1px solid infotext;
          font-size: 11px;
          margin: 11px;
          font-family: Arial;
        "
      >
        Uploaded
      </div>
    </div>
    <div
      class="cdk-live-announcer-element cdk-visually-hidden"
      aria-atomic="true"
      aria-live="polite"
    ></div>
  </body>
</html>
