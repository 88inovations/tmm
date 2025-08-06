-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2025 at 08:07 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u561342241_tmm`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `_ref_master_id` int(11) NOT NULL,
  `_ref_detail_id` int(11) NOT NULL,
  `_short_narration` varchar(255) DEFAULT NULL,
  `_narration` varchar(255) DEFAULT NULL,
  `_reference` varchar(255) DEFAULT NULL,
  `_transaction` varchar(100) DEFAULT NULL,
  `_voucher_type` varchar(10) NOT NULL DEFAULT 'JV',
  `_date` date DEFAULT NULL,
  `_table_name` varchar(150) DEFAULT NULL,
  `_account_head` int(11) NOT NULL DEFAULT 0,
  `_account_group` int(11) NOT NULL DEFAULT 0,
  `_account_ledger` int(11) NOT NULL DEFAULT 0,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_name` varchar(250) DEFAULT NULL,
  `_status` int(11) NOT NULL DEFAULT 1,
  `_serial` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `_voucher_code` varchar(255) DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_rel_ledger_id_one` int(11) NOT NULL DEFAULT 0,
  `_rel_ledger_id_two` int(11) NOT NULL DEFAULT 0,
  `_rel_ledger_id_three` int(11) NOT NULL DEFAULT 0,
  `_rel_ledger_id_four` int(11) NOT NULL DEFAULT 0,
  `_fescal_period` varchar(100) DEFAULT NULL,
  `_fescal_year` varchar(100) DEFAULT NULL,
  `_check_no` varchar(60) DEFAULT NULL,
  `_issue_date` date DEFAULT NULL,
  `_cash_date` date DEFAULT NULL,
  `_pair` double NOT NULL DEFAULT 0,
  `_ref_table` varchar(200) DEFAULT NULL,
  `_lc_no` varchar(200) DEFAULT NULL,
  `_lc_stage_id` int(11) NOT NULL DEFAULT 0,
  `_lc_id` int(11) NOT NULL DEFAULT 0,
  `_f_currency` varchar(50) DEFAULT NULL,
  `_foreign_amount` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `_check_number` varchar(100) DEFAULT NULL,
  `_approved_status` tinyint(4) NOT NULL DEFAULT 0,
  `_approved_by` int(11) NOT NULL DEFAULT 0,
  `_month` int(11) NOT NULL DEFAULT 0,
  `_year` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_details`
--

CREATE TABLE `account_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ad_id` bigint(20) NOT NULL DEFAULT 0,
  `ad_code` varchar(191) DEFAULT NULL,
  `ad_code_manual` varchar(191) DEFAULT NULL COMMENT 'manual code input by user which connected other software',
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `ad_name` varchar(191) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ad_address` text DEFAULT NULL,
  `ledger_image` varchar(255) DEFAULT NULL,
  `ledger_nid_image` varchar(255) DEFAULT NULL,
  `_note` longtext DEFAULT NULL,
  `ad_al2_id` bigint(20) NOT NULL DEFAULT 0,
  `ad_code_id` bigint(20) NOT NULL DEFAULT 0,
  `ad_flag` bigint(20) NOT NULL DEFAULT 0,
  `is_receive_account` bigint(20) NOT NULL DEFAULT 0 COMMENT 'not receveable =0,receveable=1',
  `ad_mem_flg` bigint(20) NOT NULL DEFAULT 0,
  `ad_ref_name` varchar(191) DEFAULT NULL,
  `ad_ref_cell_no` bigint(20) NOT NULL DEFAULT 0,
  `ad_delivery_address` varchar(191) DEFAULT NULL,
  `ad_credit_limit` bigint(20) NOT NULL DEFAULT 0,
  `ad_cust_type` bigint(20) NOT NULL DEFAULT 0 COMMENT 'credit=0,cash=1,cash/credit=2',
  `ad_td_id` varchar(191) DEFAULT NULL,
  `ad_mm_id` varchar(191) DEFAULT NULL,
  `ad_cust_code` bigint(20) NOT NULL DEFAULT 0,
  `branch_id` bigint(20) NOT NULL DEFAULT 0,
  `ad_target_qty` bigint(20) NOT NULL DEFAULT 0,
  `ad_bin_nid_no` bigint(20) NOT NULL DEFAULT 0,
  `ad_email` varchar(191) DEFAULT NULL,
  `ad_nbr_list_type` int(11) NOT NULL DEFAULT 1 COMMENT 'type check by nbr list 1=register,2=non-register,3=listed',
  `ad_eff_date` varchar(191) DEFAULT NULL,
  `created_by` varchar(191) DEFAULT NULL COMMENT 'created action by an user',
  `updated_by` varchar(191) DEFAULT NULL COMMENT 'updated action by an user',
  `permited_user` varchar(191) DEFAULT NULL COMMENT 'permited user id ',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'status 1 for active 0 for inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_groups`
--

CREATE TABLE `account_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(100) NOT NULL,
  `_code` varchar(100) NOT NULL,
  `_details` longtext DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `_account_head_id` bigint(20) UNSIGNED NOT NULL,
  `_parent_id` int(11) NOT NULL DEFAULT 0,
  `_show_filter` tinyint(4) NOT NULL DEFAULT 1,
  `_short` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_groups`
--

INSERT INTO `account_groups` (`id`, `_name`, `_code`, `_details`, `_status`, `_created_by`, `_updated_by`, `_account_head_id`, `_parent_id`, `_show_filter`, `_short`, `created_at`, `updated_at`) VALUES
(3, 'Bank Accounts', '', '', 1, NULL, NULL, 2, 0, 1, 1, '2022-03-01 23:50:57', '2025-05-16 08:49:08'),
(4, 'Cash-in-hand', '', '', 1, NULL, NULL, 2, 0, 1, 2, '2022-03-01 23:51:07', '2025-05-16 08:49:08'),
(7, 'Other Expense', '', '', 1, NULL, NULL, 15, 0, 1, 3, '2022-03-02 01:11:28', '2025-05-16 08:49:08'),
(8, 'Indirect Expense', '', '', 1, NULL, NULL, 10, 0, 1, 4, '2023-08-06 21:15:34', '2025-05-16 08:49:08'),
(9, 'Direct Expenes', '', '', 1, NULL, NULL, 10, 0, 1, 5, '2023-08-06 21:15:45', '2025-05-16 08:49:08'),
(11, 'Deposits (Asset)', '', '', 1, NULL, NULL, 2, 0, 1, 6, '2023-09-30 17:10:09', '2025-05-16 08:49:08'),
(13, 'Loan & Advance  To Project Office', '', '', 1, NULL, NULL, 2, 0, 1, 7, '2023-09-30 17:12:07', '2025-05-16 08:49:08'),
(14, 'Loans & Advances Employee', '', '', 1, NULL, NULL, 2, 0, 1, 8, '2023-09-30 17:12:35', '2025-05-16 08:49:08'),
(15, 'Earnest Money', '', '', 1, NULL, NULL, 2, 0, 1, 9, '2023-09-30 17:13:09', '2025-05-16 08:49:08'),
(16, 'Inner Company Transaction(Asset)', '', '', 1, NULL, NULL, 2, 0, 1, 10, '2023-09-30 17:14:08', '2025-05-16 08:49:08'),
(17, 'Stock-in-hand', '', '', 1, NULL, NULL, 2, 0, 1, 11, '2023-09-30 17:14:52', '2025-05-16 08:49:08'),
(18, 'Accounts Receivable (Tender)', '', '', 1, NULL, NULL, 2, 0, 1, 12, '2023-09-30 17:16:04', '2025-05-16 08:49:08'),
(19, 'Accounts Receivable (Kabikha)', '', '', 1, NULL, NULL, 2, 0, 1, 13, '2023-09-30 17:16:42', '2025-05-16 08:49:08'),
(20, 'Duties & Taxes', '', '', 1, NULL, NULL, 5, 0, 1, 14, '2023-09-30 17:17:10', '2025-05-16 08:49:08'),
(21, 'Provisions', '', '', 1, NULL, NULL, 5, 0, 1, 15, '2023-09-30 17:17:27', '2025-05-16 08:49:08'),
(22, 'Accounts Payable', '', '', 1, NULL, NULL, 5, 0, 1, 16, '2023-09-30 17:17:47', '2025-05-16 08:49:08'),
(23, 'Office Equipment', '', '', 1, NULL, NULL, 3, 0, 1, 17, '2023-09-30 17:18:04', '2025-05-16 08:49:08'),
(24, 'Fuel & Oil Expenses', '', '', 1, NULL, NULL, 15, 0, 1, 18, '2023-09-30 17:18:38', '2025-05-16 08:49:08'),
(27, 'Office Rent', '', '', 1, NULL, NULL, 15, 0, 1, 19, '2023-09-30 17:19:54', '2025-05-16 08:49:08'),
(30, 'Bank Over Draft A/C', '', '', 1, NULL, NULL, 5, 0, 1, 20, '2023-09-30 17:21:37', '2025-05-16 08:49:08'),
(31, 'Secured Loans', '', '', 1, NULL, NULL, 6, 0, 1, 21, '2023-09-30 17:22:12', '2025-05-16 08:49:08'),
(32, 'Unsecured Loans', '', '', 1, NULL, NULL, 5, 0, 1, 22, '2023-09-30 17:22:38', '2025-05-16 08:49:08'),
(36, 'Supplies and materials', '', '', 1, NULL, NULL, 10, 0, 1, 23, '2023-10-01 21:57:28', '2025-05-16 08:49:08'),
(37, 'Madrasah Income', '', '', 1, NULL, NULL, 20, 0, 1, 25, '2023-10-01 22:01:11', '2025-05-16 08:49:08'),
(38, 'Inventory', '', '', 1, NULL, NULL, 2, 0, 1, 26, '2023-10-01 22:02:22', '2025-05-16 08:49:08'),
(39, 'Income tax payable', '', '', 1, NULL, NULL, 5, 0, 1, 27, '2023-10-01 22:05:54', '2025-05-16 08:49:08'),
(40, 'Capital Account', '', '', 1, NULL, NULL, 7, 0, 1, 28, '2023-10-01 22:09:52', '2025-05-16 08:49:08'),
(41, 'Cost of goods sold', '', '', 1, NULL, NULL, 9, 0, 1, 29, '2023-10-02 00:49:24', '2025-05-16 08:49:08'),
(42, 'Payroll Liabilities', '', '', 1, NULL, NULL, 5, 0, 1, 30, '2023-11-24 18:59:10', '2025-05-16 08:49:08'),
(43, 'Furniture & Fixture', '', '', 1, NULL, NULL, 3, 0, 1, 31, '2024-01-29 06:44:26', '2025-05-16 08:49:08'),
(44, 'Computer & Accessories', '', '', 1, NULL, NULL, 3, 0, 1, 32, '2024-01-30 05:56:15', '2025-05-16 08:49:08'),
(45, 'Administrative Expenses', '', '', 1, NULL, NULL, 15, 0, 1, 33, '2024-04-29 06:16:56', '2025-05-16 08:49:08'),
(46, 'Operational Expenses', '', '', 1, NULL, NULL, 15, 0, 1, 34, '2024-04-29 06:17:21', '2025-05-16 08:49:08'),
(47, 'Mosque income', 'M09', '', 1, NULL, NULL, 20, 0, 1, 24, '2025-04-23 14:44:12', '2025-05-16 08:49:08'),
(48, 'Opening Balance', '', '', 1, NULL, NULL, 5, 0, 1, 35, '2025-04-30 15:13:28', '2025-05-16 08:49:08'),
(49, 'Students', '', '', 1, NULL, NULL, 2, 0, 1, 36, '2025-05-12 17:04:26', '2025-05-16 08:49:08');

-- --------------------------------------------------------

--
-- Table structure for table `account_group_configs`
--

CREATE TABLE `account_group_configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_employee_group` varchar(255) DEFAULT NULL,
  `_student_groups` varchar(255) DEFAULT NULL,
  `_honorarium_group` varchar(255) DEFAULT NULL,
  `_direct_inc_exp_heads` varchar(255) DEFAULT NULL,
  `_indirect_inc_exp_heads` varchar(255) DEFAULT NULL,
  `_direct_income_group` varchar(255) DEFAULT NULL,
  `_indirect_income_group` varchar(255) DEFAULT NULL,
  `_direct_expense_group` varchar(255) DEFAULT NULL,
  `_indirect_expense_group` varchar(255) DEFAULT NULL,
  `_cash_group` varchar(255) DEFAULT NULL,
  `_bank_group` varchar(255) DEFAULT NULL,
  `_customer_group` varchar(255) DEFAULT NULL,
  `_supplier_group` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_tax_expense_group` text DEFAULT NULL,
  `_asset_group` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_group_configs`
--

INSERT INTO `account_group_configs` (`id`, `_employee_group`, `_student_groups`, `_honorarium_group`, `_direct_inc_exp_heads`, `_indirect_inc_exp_heads`, `_direct_income_group`, `_indirect_income_group`, `_direct_expense_group`, `_indirect_expense_group`, `_cash_group`, `_bank_group`, `_customer_group`, `_supplier_group`, `created_at`, `updated_at`, `_tax_expense_group`, `_asset_group`) VALUES
(2, '42', '49', '', '9,37', '7,8,24,27,37,45,46', '47', '37', '9', '7,8,24,27,45,46', '4', '3', '18,19', '22', NULL, '2025-05-12 17:04:48', '1', '1'),
(3, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `account_heads`
--

CREATE TABLE `account_heads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(100) NOT NULL,
  `_account_id` int(11) NOT NULL DEFAULT 0,
  `_parent_id` int(11) NOT NULL DEFAULT 0,
  `_has_parent` int(11) NOT NULL DEFAULT 0,
  `_has_child` int(11) NOT NULL DEFAULT 0,
  `_level` int(11) NOT NULL DEFAULT 1,
  `_code` varchar(100) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_parent_id_second` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_heads`
--

INSERT INTO `account_heads` (`id`, `_name`, `_account_id`, `_parent_id`, `_has_parent`, `_has_child`, `_level`, `_code`, `_status`, `_created_by`, `_updated_by`, `created_at`, `updated_at`, `_parent_id_second`) VALUES
(2, 'Current assets', 1, 0, 0, 0, 1, 'ca-1', 1, NULL, NULL, '2022-02-28 05:13:17', '2022-03-14 23:46:11', 0),
(3, 'Fixed assets', 1, 0, 0, 0, 1, 'fa-1', 1, NULL, NULL, '2022-02-28 05:13:27', '2022-03-14 23:46:22', 0),
(5, 'Current liabilities', 2, 0, 0, 0, 1, 'cl', 1, NULL, NULL, '2022-02-28 05:13:44', '2022-03-16 22:06:18', 0),
(6, 'Long Term liabilities', 2, 0, 0, 0, 1, 'L-2', 1, NULL, NULL, '2022-02-28 05:13:51', '2022-03-14 23:21:43', 0),
(7, 'Capital Account', 5, 0, 0, 0, 1, 'O-1', 1, NULL, NULL, '2022-02-28 05:13:58', '2023-09-30 16:52:10', 0),
(9, 'Cost of sales', 4, 0, 0, 0, 1, 'cos-1', 1, NULL, NULL, '2022-02-28 05:14:14', '2022-03-14 23:22:31', 0),
(10, 'Direct Expenses', 4, 0, 0, 0, 1, 'E-2', 1, NULL, NULL, '2022-02-28 05:14:20', '2023-09-30 16:54:26', 0),
(15, 'Expenses', 4, 0, 0, 0, 1, 'OE-1', 1, NULL, NULL, '2022-03-02 01:10:25', '2025-04-23 14:54:37', 0),
(20, 'Revenue', 3, 0, 0, 0, 1, '20', 1, NULL, NULL, '2023-09-30 16:58:07', '2024-01-29 11:18:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_ledgers`
--

CREATE TABLE `account_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_account_head_id` bigint(20) NOT NULL DEFAULT 0,
  `_name` varchar(255) DEFAULT NULL,
  `_alious` varchar(200) DEFAULT NULL,
  `_code` varchar(50) DEFAULT NULL,
  `_image` varchar(250) DEFAULT NULL,
  `_nid` varchar(250) DEFAULT NULL,
  `_other_document` longtext DEFAULT NULL,
  `_email` varchar(60) DEFAULT NULL,
  `_phone` varchar(60) DEFAULT NULL,
  `_address` text DEFAULT NULL,
  `_credit_limit` double(15,4) NOT NULL DEFAULT 0.0000,
  `_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_is_user` int(11) DEFAULT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_is_sales_form` int(11) NOT NULL DEFAULT 0,
  `_is_purchase_form` int(11) NOT NULL DEFAULT 0,
  `_is_all_branch` int(11) NOT NULL DEFAULT 0,
  `_short` int(11) NOT NULL DEFAULT 5,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_used` tinyint(4) NOT NULL DEFAULT 1,
  `_show` int(11) NOT NULL DEFAULT 1 COMMENT '0=not show,1 =income statement,2 = balance sheet',
  `_note` text DEFAULT NULL,
  `opening_dr_amount` double NOT NULL DEFAULT 0,
  `opening_cr_amount` double NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_main_account_id` int(11) NOT NULL DEFAULT 0,
  `_acc_head_pl3_id` int(11) NOT NULL DEFAULT 0,
  `_acc_head_pl2_id` int(11) NOT NULL DEFAULT 0,
  `_nidimage` varchar(255) DEFAULT NULL,
  `_checkpage_image` varchar(255) DEFAULT NULL,
  `_designation` varchar(150) DEFAULT NULL,
  `_specialist` varchar(200) DEFAULT NULL,
  `_address_2` text DEFAULT NULL,
  `_date_of_birth` date DEFAULT NULL,
  `_whatsup_number` varchar(50) DEFAULT NULL,
  `_reg_no` varchar(100) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_ledgers`
--

INSERT INTO `account_ledgers` (`id`, `_account_group_id`, `_account_head_id`, `_name`, `_alious`, `_code`, `_image`, `_nid`, `_other_document`, `_email`, `_phone`, `_address`, `_credit_limit`, `_balance`, `_branch_id`, `_is_user`, `_user_id`, `_is_sales_form`, `_is_purchase_form`, `_is_all_branch`, `_short`, `_status`, `_is_used`, `_show`, `_note`, `opening_dr_amount`, `opening_cr_amount`, `_created_by`, `_updated_by`, `created_at`, `updated_at`, `_main_account_id`, `_acc_head_pl3_id`, `_acc_head_pl2_id`, `_nidimage`, `_checkpage_image`, `_designation`, `_specialist`, `_address_2`, `_date_of_birth`, `_whatsup_number`, `_reg_no`, `organization_id`, `_cost_center_id`) VALUES
(1, 37, 20, 'Admission form', '', '7-001', NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-23 14:45:25', '2025-04-28 11:13:06', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(2, 37, 20, 'Admission Fee', '', '7-002', NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-23 14:45:56', '2025-04-28 11:13:22', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(3, 37, 20, 'Monthly Tuition Fee (Ebtadae Section)', '', '7-003', NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-23 14:47:08', '2025-04-28 11:13:40', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(4, 37, 20, 'Monthly Accommodation and Fooding (Hifz Section)', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 14:49:19', '2025-04-23 14:49:19', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(5, 47, 20, 'Jumma Collection', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 14:49:57', '2025-04-23 14:49:57', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(6, 37, 20, 'Donation( Madrasah)', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 14:50:24', '2025-04-23 14:50:24', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(7, 37, 20, 'Zakat collection', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 14:51:21', '2025-04-23 14:51:21', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(8, 37, 20, 'Examination Fee', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 14:51:43', '2025-04-23 14:51:43', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(9, 37, 20, 'Miscellaneous Income', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 14:53:04', '2025-04-23 14:53:04', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(10, 45, 15, 'Cleaning Expenses', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:27:59', '2025-04-23 15:27:59', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(11, 45, 15, 'Repair and Maintenance', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 12086.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:28:31', '2025-04-23 15:28:31', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(12, 45, 15, 'Office Equipment', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:29:00', '2025-04-23 15:29:00', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(13, 45, 15, 'Donation', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:29:42', '2025-04-23 15:29:42', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(14, 45, 15, 'Salary Madrasah', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 107500.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-23 15:30:03', '2025-04-23 15:31:29', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(15, 45, 15, 'Salary Mosque', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 13500.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:30:57', '2025-04-23 15:30:57', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(16, 45, 15, 'Festival Bopnus', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:37:07', '2025-04-23 15:37:07', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(17, 45, 15, 'office Expense', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:38:15', '2025-04-23 15:38:15', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(18, 45, 15, 'Medical Expenses', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:38:40', '2025-04-23 15:38:40', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(19, 45, 15, 'Tanning Expense', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:39:19', '2025-04-23 15:39:19', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(20, 45, 15, 'Stationery', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 460.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:39:51', '2025-04-23 15:39:51', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(21, 45, 15, 'Internet Bill', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 500.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:40:10', '2025-04-23 15:40:10', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(22, 45, 15, 'Electric Bill', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 17858.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:40:31', '2025-04-23 15:40:31', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(23, 45, 15, 'Firewood', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:41:06', '2025-04-23 15:41:06', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(24, 45, 15, 'Entertainment (Fooding & Accomodation)', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:42:24', '2025-04-23 15:42:24', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(25, 45, 15, 'Uniform', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:43:27', '2025-04-23 15:43:27', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(26, 45, 15, 'Islamic Cultural Program', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:43:58', '2025-04-23 15:43:58', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(27, 45, 15, 'Study Tour', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:44:22', '2025-04-23 15:44:22', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(28, 45, 15, 'WAZ Mahfil', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:44:48', '2025-04-23 15:44:48', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(29, 45, 15, 'License and Renewal', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:45:17', '2025-04-23 15:45:17', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(30, 45, 15, 'Advertisement', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:45:51', '2025-04-23 15:45:51', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(31, 45, 15, 'Admission Expenses', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:46:25', '2025-04-23 15:46:25', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(32, 45, 15, 'Entertainment', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:46:52', '2025-04-23 15:46:52', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(33, 45, 15, 'Examination Expenses', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:47:23', '2025-04-23 15:47:23', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(34, 45, 15, 'Conveyance', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 15:47:47', '2025-04-23 15:47:47', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(35, 4, 2, 'Cash-In -Hand', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, -310305.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-23 16:59:43', '2025-04-23 16:59:43', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(36, 3, 2, 'FSIBL A/C', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 781590.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-24 16:42:44', '2025-05-01 12:04:58', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(37, 32, 5, 'Loan From MD Sir (Tarafder Ruhul Amin)', '', '42-0', NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-27 13:05:46', '2025-04-29 12:51:18', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(38, 45, 15, 'Grocessary  Expense', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 75840.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-27 15:31:19', '2025-04-27 15:31:19', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(39, 42, 5, 'Mowlana Abu Sufian(Assistant Principle)', '', '42-1', NULL, 'N/A', NULL, NULL, NULL, 'N/A', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, NULL, 0, 0, '46-Admin', '49-Shihab', '2025-04-29 11:08:01', '2025-05-16 09:33:39', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(40, 42, 5, 'Mowlana Ruhul Quddush', '', '42-2', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-29 12:36:39', '2025-04-29 12:36:39', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(41, 42, 5, 'Mowlana Shoriful islam', '', '42-3', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-29 12:37:20', '2025-04-29 12:37:20', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(42, 42, 5, 'Hafiz Naim Hossain', '', '42-4', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-29 12:40:06', '2025-04-29 12:40:06', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(43, 42, 5, 'Mowlana Zahidul Islam', '', '42-5', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-29 12:40:48', '2025-04-29 12:40:48', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(44, 42, 5, 'Hafiz Mowlana MD Robiul', '', '42-6', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-29 12:42:38', '2025-04-29 12:42:38', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(45, 42, 5, 'Rehena Begum', '', '42-7', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-29 12:43:35', '2025-04-29 12:43:35', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(46, 42, 5, 'Md. Abu Shihab', '', '42-8', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-29 12:44:10', '2025-04-29 12:44:10', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(47, 42, 5, 'Md. Nahid Hasan', '', '42-9', NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-29 12:44:43', '2025-04-29 12:49:28', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(48, 42, 5, 'Firoza Begum', '', '42-10', NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-29 12:45:18', '2025-04-29 12:49:55', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(49, 42, 5, 'Jannati Begum', '', '42-11', NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-29 12:46:36', '2025-04-29 12:50:13', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(50, 42, 5, 'Md. Sabbir Hossain', '', '42-12', NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 0.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, NULL, 0, 0, '49-Shihab', '49-Shihab', '2025-04-29 12:47:22', '2025-04-29 12:50:27', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(51, 48, 5, 'Opening Balance', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, -856824.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-04-30 15:13:55', '2025-04-30 15:13:55', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(52, 45, 15, 'Electricial Goods Purchase', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 185095.0000, 1, 1, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-07 15:42:18', '2025-05-07 15:42:18', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(54, 49, 2, 'Mst. Samia Khatun', 'Md. Zillur Rahman', '1', NULL, '', NULL, 'mst.samiakhatun@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:15:10', '2025-05-12 17:15:10', 1, 0, 0, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', '0000-00-00', NULL, NULL, 1, 1),
(55, 49, 2, 'Mst. Samia Khatun', 'Md. Zillur Rahman', '00001', NULL, '', NULL, 'mst.samiakhatun@gmail.com.1@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05', 1, 0, 0, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', '0000-00-00', NULL, NULL, 1, 1),
(56, 49, 2, 'Mst. Suraiya Khatun', 'Md. Mukul ', '00002', NULL, '', NULL, 'mst.suraiyakhatun@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(57, 49, 2, 'Md. Siyam Molla', 'Shabuddin Molla', '00003', NULL, '', NULL, 'md.siyammolla@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(58, 49, 2, 'Md. Khalid Bin Walid Yeamin', 'Md. Shafikul Islam Lovelu', '00004', NULL, '', NULL, 'md.khalidbinwalidyeamin@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(59, 49, 2, 'Rafin Hasan', 'Akbar Ali', '00005', NULL, '', NULL, 'rafinhasan@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(60, 49, 2, 'Md. Sohaib Ansari', 'Md. Dawood Hossain', '00006', NULL, '', NULL, 'md.sohaibansari@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(61, 49, 2, 'Tasin Hasan Ahad', 'Md. Zahidul Islam', '00007', NULL, '', NULL, 'tasinhasanahad@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(62, 49, 2, 'Mst. Jannati Khatun', 'Simul Molla', '00008', NULL, '', NULL, 'mst.jannatikhatun@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(63, 49, 2, 'Raisa Akhter Roza', 'Md. Billal Hossain', '00009', NULL, '', NULL, 'raisaakhterroza@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(64, 49, 2, 'Mst. Saima Khatun', 'Md. Sagor Hossain', '00010', NULL, '', NULL, 'mst.saimakhatun@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(65, 49, 2, 'Mst. Rusa Khatun', 'Md. Ramzan Ali', '00011', NULL, '', NULL, 'mst.rusakhatun@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(66, 49, 2, 'Elma Khatun', 'Md. Yeasin Ali', '00012', NULL, '', NULL, 'elmakhatun@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(67, 49, 2, 'Hriday Hossain', 'Md. Mukul ', '00013', NULL, '', NULL, 'hridayhossain@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(68, 49, 2, 'Litun Jira', 'Md. Babul Hossain', '00014', NULL, '', NULL, 'litunjira@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(69, 49, 2, 'Mst. Humayra Khatun Johani', 'Md. Mahabur Rahaman', '00015', NULL, '', NULL, 'mst.humayrakhatunjohani@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(70, 49, 2, 'Afrin', 'Md. Mokther Hossen', '00016', NULL, '', NULL, 'afrin@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(71, 49, 2, 'Amir Hamza', 'Md. Ismile Hossin', '00017', NULL, '', NULL, 'amirhamza@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(72, 49, 2, 'Al-Alim', 'Md. Jihad Hossain', '00018', NULL, '', NULL, 'al-alim@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(73, 49, 2, 'Mohammad Ullah', 'Md. Zahid Khan ', '00019', NULL, '', NULL, 'mohammadullah@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(74, 49, 2, 'Sifat Bin Sofik', 'Md. Sofikul Islam', '00020', NULL, '', NULL, 'sifatbinsofik@gmail.com', '', '', 0.0000, 600.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(75, 49, 2, 'Aysha Khatun', 'Tabibarrahman Fazle Karim', '00021', NULL, '', NULL, 'ayshakhatun@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(76, 49, 2, 'Safia Akter Sohi', 'Md. Shohel Rana', '00022', NULL, '', NULL, 'safiaaktersohi@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(77, 49, 2, 'Fatama Akter Anisha', 'Md. Arif Hossain', '00023', NULL, '', NULL, 'fatamaakteranisha@gmail.com', '', '', 0.0000, 600.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(78, 49, 2, 'Zannati Khatun', 'Md. Shamim Hossan', '00024', NULL, '', NULL, 'zannatikhatun@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(79, 49, 2, 'Tazmir hossen', 'Md. Tohidul Bisas', '00025', NULL, '', NULL, 'tazmirhossen@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(80, 49, 2, 'Md. Shahed Hossan', 'Mitul Hossin', '00026', NULL, '', NULL, 'md.shahedhossan@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(81, 49, 2, 'Mst. Jannatul Khatun', 'Md. Iqbal Hossain', '00027', NULL, '', NULL, 'mst.jannatulkhatun@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(82, 49, 2, 'Ayeat Islam', 'Shariful Islam', '00028', NULL, '', NULL, 'ayeatislam@gmail.com', '', '', 0.0000, 600.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(83, 49, 2, 'Mohsina Mariam', 'Md. Abdullah', '00029', NULL, '', NULL, 'mohsinamariam@gmail.com', '', '', 0.0000, 600.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(84, 49, 2, 'Mst. Maliha Jannat', 'Md. Selim Molla', '00030', NULL, '', NULL, 'mst.malihajannat@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(85, 49, 2, 'Rafid Hossen', 'Md. Farhad Hossain', '00031', NULL, '', NULL, 'rafidhossen@gmail.com', '', '', 0.0000, 600.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(86, 49, 2, 'Md. Sajjad Hossain', 'Md. Jashim Uddin ', '00032', NULL, '', NULL, 'md.sajjadhossain@gmail.com', '', '', 0.0000, 600.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(87, 49, 2, 'Md. Sazim Hossen', 'Salaiman Hossain', '00033', NULL, '', NULL, 'md.sazimhossen@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(88, 49, 2, 'Md. Siyam Hossen', 'Md. Kamrujjaman', '00034', NULL, '', NULL, 'md.siyamhossen@gmail.com', '', '', 0.0000, 600.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(89, 49, 2, 'Mst. Khadija Khatun', 'Oasman Ali', '00035', NULL, '', NULL, 'mst.khadijakhatun@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(90, 49, 2, 'Ashmatulya Hussain', 'Md. Sabur Hossain', '00036', NULL, '', NULL, 'ashmatulyahussain@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(91, 49, 2, 'Abu Hussain Tamim', 'Md. Golam Kadir', '00037', NULL, '', NULL, 'abuhussaintamim@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(92, 49, 2, 'Md. Jubayer Hossen', 'Shoel Rana ', '00038', NULL, '', NULL, 'md.jubayerhossen@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(93, 49, 2, 'Tasnim Khatun', 'Rana Hossan', '00039', NULL, '', NULL, 'tasnimkhatun@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(94, 49, 2, 'Mst. Homaira Khatun', 'Md. Abul Kalam molla', '00040', NULL, '', NULL, 'mst.homairakhatun@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(95, 49, 2, 'Mst. Jacia Khatun ', 'Md. Imamul Haque', '00041', NULL, '', NULL, 'mst.jaciakhatun@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(96, 49, 2, 'Roshan azam', 'Md. Golam Azam', '00042', NULL, '', NULL, 'roshanazam@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(97, 49, 2, 'Ajmain Hasan Rijvi', 'Md. Anwar Zahid', '00043', NULL, '', NULL, 'ajmainhasanrijvi@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(98, 49, 2, 'Md. Mustakim Hossain', 'Md. Mukul Hossain', '00044', NULL, '', NULL, 'md.mustakimhossain@gmail.com', '', '', 0.0000, 600.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(99, 49, 2, 'Mst. Sumaiya Khatun', 'Md. Mukul ', '00045', NULL, '', NULL, 'mst.sumaiyakhatun@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(100, 49, 2, 'Arisha Akhtar', 'Md. Akthar Hossen', '00046', NULL, '', NULL, 'arishaakhtar@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(101, 49, 2, 'Md. Tamim Hasan', 'Md. Ashad Hossain', '00047', NULL, '', NULL, 'md.tamimhasan@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(102, 49, 2, 'Md. Amanullah', 'Md. Anoyarul Islam', '00048', NULL, '', NULL, 'md.amanullah@gmail.com', '', '', 0.0000, 1000.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(103, 49, 2, 'Riyadh', 'Md. Mahabub ', '00049', NULL, '', NULL, 'riyadh@gmail.com', '', '', 0.0000, 800.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(104, 49, 2, 'Tachin Ahmed', 'Md. Matiar Mollah', '00050', NULL, '', NULL, 'tachinahmed@gmail.com', '', '', 0.0000, 600.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(105, 49, 2, 'Abrar Fahim', 'Md. Sazol Hossain', '00051', NULL, '', NULL, 'abrarfahim@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(106, 49, 2, 'Md. Billal Hosen', 'Md. Mahabur Rahaman', '00052', NULL, '', NULL, 'md.billalhosen@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(107, 49, 2, 'Mst. Tabassum Khatun', 'Md. Tuhin Hossain', '00053', NULL, '', NULL, 'mst.tabassumkhatun@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(108, 49, 2, 'Maimun Jubayer', 'Md. Bablu Hossain', '00054', NULL, '', NULL, 'maimunjubayer@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(109, 49, 2, 'Lamia Min Samia', 'G. M. Inamul Hasan Mony', '00055', NULL, '', NULL, 'lamiaminsamia@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(110, 49, 2, 'Mst. Samiya Akter', 'Md. Habibur Rahman', '00056', NULL, '', NULL, 'mst.samiyaakter@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(111, 49, 2, 'Md. Imtiaz Hossain Imu', 'Elias Hossain', '00057', NULL, '', NULL, 'md.imtiazhossainimu@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(112, 49, 2, 'Md. Ahnaf Abid', 'Md. Golam Kader', '00058', NULL, '', NULL, 'md.ahnafabid@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(113, 49, 2, 'Amatulla Tasnim Maroa', 'Mohammad Ruhul Kuddus', '00059', NULL, '', NULL, 'amatullatasnimmaroa@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(114, 49, 2, 'Md. Abu Jorr', 'Billal Hossen ', '00060', NULL, '', NULL, 'md.abujorr@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(115, 49, 2, 'Taskin Hussain', 'Md. Manik Hossen', '00061', NULL, '', NULL, 'taskinhussain@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(116, 49, 2, 'Md. Jayed Sabit', 'Md. Golam Kader', '00062', NULL, '', NULL, 'md.jayedsabit@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(117, 49, 2, 'Tasmin Nahar Sinthia', 'Robiul Islam', '00063', NULL, '', NULL, 'tasminnaharsinthia@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(118, 49, 2, 'Mst. Lamia Akter', 'Md. Tarikul Islam', '00064', NULL, '', NULL, 'mst.lamiaakter@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(119, 49, 2, 'Mst. Aysha Seddika', 'Md. Moniruzzaman Jebon', '00065', NULL, '', NULL, 'mst.ayshaseddika@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(120, 49, 2, 'Md. Mustakim Hossen', 'Salaiman Hossain', '00066', NULL, '', NULL, 'md.mustakimhossen@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(121, 49, 2, 'Md. Muzahid Hossen', 'Salha Uddin', '00067', NULL, '', NULL, 'md.muzahidhossen@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(122, 49, 2, 'Md. Abdur Rahman', 'Md. Israil Hossain', '00068', NULL, '', NULL, 'md.abdurrahman@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(123, 49, 2, 'Mst. Mariam Khatun', 'Md. Abdul Quader Raihan', '00069', NULL, '', NULL, 'mst.mariamkhatun@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(124, 49, 2, 'Nasim Hossen', 'Mst. Sohag Hossain', '00070', NULL, '', NULL, 'nasimhossen@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', '0000-00-00', NULL, NULL, 1, 1),
(125, 49, 2, 'Md. Hussain ', 'Md. Jahidul Islam', '00071', NULL, '', NULL, 'md.hussain@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(126, 49, 2, 'Safia Khatun', '', '00072', NULL, '', NULL, 'safiakhatun@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', '0000-00-00', NULL, NULL, 1, 1),
(127, 49, 2, 'Mst. Eshita ', 'Md. Elias Hossain', '00073', NULL, '', NULL, 'mst.eshita@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(128, 49, 2, 'Mst. Moriam Khatun', 'Md. Elias Hossain', '00074', NULL, '', NULL, 'mst.moriamkhatun@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(129, 49, 2, 'Jannatul Ferdous Toha', 'Md. Abbas Ali', '00075', NULL, '', NULL, 'jannatulferdoustoha@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(130, 49, 2, 'Mst. Mim Akter', 'Md. Ismile Hossin', '00076', NULL, '', NULL, 'mst.mimakter@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(131, 49, 2, 'Mumtahina Mahmuda', 'MOU. Md. Shariful Islam', '00077', NULL, '', NULL, 'mumtahinamahmuda@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(132, 49, 2, 'Md. Samiul Islam', 'Sazadul Islam Manik', '00078', NULL, '', NULL, 'md.samiulislam@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(133, 49, 2, 'Md. Abu Talha Rabby', 'Md. Abul Bashar', '00079', NULL, '', NULL, 'md.abutalharabby@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(134, 49, 2, 'Md. Rafsan Hossain', 'Md. Shohel Rana', '00080', NULL, '', NULL, 'md.rafsanhossain@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(135, 49, 2, 'Md. Jihad Hasan Chiku', 'Md. Mahabub ', '00081', NULL, '', NULL, 'md.jihadhasanchiku@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(136, 49, 2, 'Md. Jidni Hasan', 'Md. Chanchal Ali Biswas', '00082', NULL, '', NULL, 'md.jidnihasan@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(137, 49, 2, 'Md. Sihab Uddin', 'Md. Abdul Jubbar', '00083', NULL, '', NULL, 'md.sihabuddin@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(138, 49, 2, 'Muttasin Islam Noman\n', 'Robiul Islam', '00084', NULL, '', NULL, 'muttasinislamnoman\n@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(139, 49, 2, 'Md. Alif Hasan Sawm', 'Md. Osman Goni', '00085', NULL, '', NULL, 'md.alifhasansawm@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(140, 49, 2, 'Md. Hossain', 'Jashim Uddin', '00086', NULL, '', NULL, 'md.hossain@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(141, 49, 2, 'Namia Akter Najifa', 'Md. Asaduszzaman', '00087', NULL, '', NULL, 'namiaakternajifa@gmail.com', '', '', 0.0000, 1250.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(142, 49, 2, '', '', '00088', NULL, '', NULL, '@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(143, 49, 2, '', '', '00089', NULL, '', NULL, '@gmail.com.1@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(144, 49, 2, '', '', '00090', NULL, '', NULL, '@gmail.com.2@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(145, 49, 2, '', '', '00091', NULL, '', NULL, '@gmail.com.3@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(146, 37, 20, 'Admission Fee Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 22500.0000, 1, 0, 0, 1, 1, 1, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:29:29', '2025-05-12 17:29:29', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(147, 37, 20, 'Tuition Fee Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, -96250.0000, 1, 0, 0, 1, 1, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:29:55', '2025-05-12 17:29:55', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(148, 37, 20, 'Annual Fee Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 0, 0, 1, 1, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:30:20', '2025-05-12 17:30:20', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(149, 37, 20, 'Exam Fee Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 0, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:30:39', '2025-05-12 17:30:39', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(150, 37, 20, 'Monthly Food Fee Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 0, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:30:57', '2025-05-12 17:30:57', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(151, 37, 20, 'Residential Fee Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 0, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:31:09', '2025-05-12 17:31:09', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(152, 37, 20, 'Other Fee Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 0, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:31:23', '2025-05-12 17:31:23', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(153, 37, 20, 'Other 2 Fee Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 0, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:31:34', '2025-05-12 17:31:34', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(154, 37, 20, 'Other 3 Fee Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 0, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:31:47', '2025-05-12 17:31:47', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(155, 37, 20, 'Discount Ledger', '', '', NULL, '', NULL, NULL, NULL, '', 0.0000, 0.0000, 1, 0, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-12 17:32:00', '2025-05-12 17:32:00', 3, 0, 0, NULL, NULL, '', '', '', '0000-00-00', '', '', 1, 1),
(156, 49, 2, 'Md.Jubayet Hossen', '', '00092', NULL, '20094114777021705', NULL, '', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:01:16', '2025-05-19 12:01:16', 1, 0, 0, NULL, NULL, NULL, NULL, '', '2009-12-08', NULL, NULL, 1, 1),
(157, 49, 2, 'Tanveen Hassan Adar', 'Md. Akkus Ali', '00093', NULL, '', NULL, 'tanveenhassanadar@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(158, 49, 2, 'Md. Easin Arafat', 'Saiful Islam', '00094', NULL, '', NULL, 'md.easinarafat@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(159, 49, 2, 'Huzaifa Jubayer', 'Md.Mominul Islam', '00095', NULL, '', NULL, 'huzaifajubayer@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(160, 49, 2, 'Sabid Hasan', 'Md.Mominul Islam', '00096', NULL, '', NULL, 'sabidhasan@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(161, 49, 2, 'Fahim Foysal', 'Azgor Ali ', '00097', NULL, '', NULL, 'fahimfoysal@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(162, 49, 2, 'Md. Aminur Rahaman', 'Saydur Rahman', '00098', NULL, '', NULL, 'md.aminurrahaman@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(163, 49, 2, 'Md.Ismail hossain.', 'Md Moniruzzaman', '00099', NULL, '', NULL, 'md.ismailhossain.@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(164, 49, 2, 'Mohammad Ullah', 'Anisur Rahaman', '00100', NULL, '', NULL, 'mohammadullah@gmail.com.1@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(165, 49, 2, 'Zihad Islam', 'Md. Firoz Hossain', '00101', NULL, '', NULL, 'zihadislam@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(166, 49, 2, 'Md. Jihadul Islam Jihad', 'Md. Shamsur Raman', '00102', NULL, '', NULL, 'md.jihadulislamjihad@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(167, 49, 2, 'Md. Ramjan Hossen', 'Md. Mintu Molla', '00103', NULL, '', NULL, 'md.ramjanhossen@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(168, 49, 2, 'Md. Bhauddin ', 'Md. Liton Hossen ', '00104', NULL, '', NULL, 'md.bhauddin@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(169, 49, 2, 'Md. Rafith', 'Md. Solaman', '00105', NULL, '', NULL, 'md.rafith@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(170, 49, 2, 'Sifat Hossen', 'Ashadur Rahaman', '00106', NULL, '', NULL, 'sifathossen@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(171, 49, 2, 'Md. Tasin Hossen', 'Md. Iqbal Hossain', '00107', NULL, '', NULL, 'md.tasinhossen@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1);
INSERT INTO `account_ledgers` (`id`, `_account_group_id`, `_account_head_id`, `_name`, `_alious`, `_code`, `_image`, `_nid`, `_other_document`, `_email`, `_phone`, `_address`, `_credit_limit`, `_balance`, `_branch_id`, `_is_user`, `_user_id`, `_is_sales_form`, `_is_purchase_form`, `_is_all_branch`, `_short`, `_status`, `_is_used`, `_show`, `_note`, `opening_dr_amount`, `opening_cr_amount`, `_created_by`, `_updated_by`, `created_at`, `updated_at`, `_main_account_id`, `_acc_head_pl3_id`, `_acc_head_pl2_id`, `_nidimage`, `_checkpage_image`, `_designation`, `_specialist`, `_address_2`, `_date_of_birth`, `_whatsup_number`, `_reg_no`, `organization_id`, `_cost_center_id`) VALUES
(172, 49, 2, 'Md. Raihan Hossen', 'Md. Imran Hossen', '00108', NULL, '', NULL, 'md.raihanhossen@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(173, 49, 2, 'Md. Yamin Hossain', 'Md. Qutub Uddin', '00109', NULL, '', NULL, 'md.yaminhossain@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(174, 49, 2, 'Md. Arafat Hossain', 'Md. Jahidul Islam', '00110', NULL, '', NULL, 'md.arafathossain@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(175, 49, 2, 'Md. Shahed Hossain', 'Md. Shahin Hossain', '00111', NULL, '', NULL, 'md.shahedhossain@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(176, 49, 2, 'Md. Firoz Hossain', 'Md. Ripon Hossain', '00112', NULL, '', NULL, 'md.firozhossain@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(177, 49, 2, 'Muntasir Hussain', 'Maulana Md. Shariful Islam', '00113', NULL, '', NULL, 'muntasirhussain@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(178, 49, 2, 'Azmain Hossain', 'Shaheen Parvez', '00114', NULL, '', NULL, 'azmainhossain@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(179, 49, 2, 'Md.Abdur Rahaman', 'Muhammad Ruhul kuddus', '00115', NULL, '', NULL, 'md.abdurrahaman@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(180, 49, 2, 'Md. Nihad Hasan', 'Md. Turap Hossen', '00116', NULL, '', NULL, 'md.nihadhasan@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(181, 49, 2, 'Apon Hossain', 'Md. Laltu Hossain', '00117', NULL, '', NULL, 'aponhossain@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(182, 49, 2, 'Mohaiminul Islam Nirab', 'Md. Milon Hossain', '00118', NULL, '', NULL, 'mohaiminulislamnirab@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(183, 49, 2, 'Ramzan Hossain', 'Lutfar Rahman', '00119', NULL, '', NULL, 'ramzanhossain@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(184, 49, 2, 'Md. Forhad Munshi', 'Mukul Munshi', '00120', NULL, '', NULL, 'md.forhadmunshi@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(185, 49, 2, 'Md. Sabbir Hossen', 'Asadul', '00121', NULL, '', NULL, 'md.sabbirhossen@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(186, 49, 2, 'Md. Abdulla', 'Md. Halim', '00122', NULL, '', NULL, 'md.abdulla@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(187, 49, 2, 'Md. Siam Hossain', 'Md. Abu Bokkor', '00123', NULL, '', NULL, 'md.siamhossain@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(188, 49, 2, 'Khandaker Al-Karimu Islam ', 'Khandaker Md. Ziaur Rahman ', '00124', NULL, '', NULL, 'khandakeral-karimuislam @gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(189, 49, 2, 'Md. Lipu Sultan Momin', 'Md. Ripon Molla', '00125', NULL, '', NULL, 'md.lipusultanmomin@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(190, 49, 2, 'Jisan', 'Md. Shamirul', '00126', NULL, '', NULL, 'jisan@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(191, 49, 2, 'Md. Baijit', 'Abdur Rashid', '00127', NULL, '', NULL, 'md.baijit@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(192, 49, 2, '', '', '00128', NULL, '', NULL, '@gmail.com.4@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(193, 49, 2, '', '', '00129', NULL, '', NULL, '@gmail.com.5@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(194, 49, 2, '', '', '00130', NULL, '', NULL, '@gmail.com.6@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(195, 49, 2, '', '', '00131', NULL, '', NULL, '@gmail.com.7@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(196, 49, 2, '', '', '00132', NULL, '', NULL, '@gmail.com.8@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(197, 49, 2, '', '', '00133', NULL, '', NULL, '@gmail.com.9@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(198, 49, 2, '', '', '00134', NULL, '', NULL, '@gmail.com.10@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(199, 49, 2, '', '', '00135', NULL, '', NULL, '@gmail.com.11@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(200, 49, 2, '', '', '00136', NULL, '', NULL, '@gmail.com.12@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(201, 49, 2, '', '', '00137', NULL, '', NULL, '@gmail.com.13@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(202, 49, 2, '', '', '00138', NULL, '', NULL, '@gmail.com.14@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(203, 49, 2, '', '', '00139', NULL, '', NULL, '@gmail.com.15@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(204, 49, 2, '', '', '00140', NULL, '', NULL, '@gmail.com.16@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(205, 49, 2, '', '', '00141', NULL, '', NULL, '@gmail.com.17@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(206, 49, 2, '', '', '00142', NULL, '', NULL, '@gmail.com.18@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(207, 49, 2, '', '', '00143', NULL, '', NULL, '@gmail.com.19@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(208, 49, 2, '', '', '00144', NULL, '', NULL, '@gmail.com.20@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(209, 49, 2, '', '', '00145', NULL, '', NULL, '@gmail.com.21@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(210, 49, 2, '', '', '00146', NULL, '', NULL, '@gmail.com.22@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(211, 49, 2, '', '', '00147', NULL, '', NULL, '@gmail.com.23@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(212, 49, 2, '', '', '00148', NULL, '', NULL, '@gmail.com.24@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(213, 49, 2, '', '', '00149', NULL, '', NULL, '@gmail.com.25@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(214, 49, 2, '', '', '00150', NULL, '', NULL, '@gmail.com.26@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(215, 49, 2, '', '', '00151', NULL, '', NULL, '@gmail.com.27@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(216, 49, 2, '', '', '00152', NULL, '', NULL, '@gmail.com.28@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(217, 49, 2, '', '', '00153', NULL, '', NULL, '@gmail.com.29@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(218, 49, 2, '', '', '00154', NULL, '', NULL, '@gmail.com.30@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(219, 49, 2, '', '', '00155', NULL, '', NULL, '@gmail.com.31@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(220, 49, 2, '', '', '00156', NULL, '', NULL, '@gmail.com.32@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(221, 49, 2, '', '', '00157', NULL, '', NULL, '@gmail.com.33@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(222, 49, 2, '', '', '00158', NULL, '', NULL, '@gmail.com.34@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(223, 49, 2, '', '', '00159', NULL, '', NULL, '@gmail.com.35@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(224, 49, 2, '', '', '00160', NULL, '', NULL, '@gmail.com.36@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(225, 49, 2, '', '', '00161', NULL, '', NULL, '@gmail.com.37@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(226, 49, 2, '', '', '00162', NULL, '', NULL, '@gmail.com.38@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(227, 49, 2, '', '', '00163', NULL, '', NULL, '@gmail.com.39@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(228, 49, 2, '', '', '00164', NULL, '', NULL, '@gmail.com.40@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(229, 49, 2, '', '', '00165', NULL, '', NULL, '@gmail.com.41@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(230, 49, 2, '', '', '00166', NULL, '', NULL, '@gmail.com.42@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(231, 49, 2, '', '', '00167', NULL, '', NULL, '@gmail.com.43@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(232, 49, 2, '', '', '00168', NULL, '', NULL, '@gmail.com.44@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(233, 49, 2, '', '', '00169', NULL, '', NULL, '@gmail.com.45@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(234, 49, 2, '', '', '00170', NULL, '', NULL, '@gmail.com.46@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(235, 49, 2, '', '', '00171', NULL, '', NULL, '@gmail.com.47@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(236, 49, 2, '', '', '00172', NULL, '', NULL, '@gmail.com.48@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(237, 49, 2, '', '', '00173', NULL, '', NULL, '@gmail.com.49@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(238, 49, 2, '', '', '00174', NULL, '', NULL, '@gmail.com.50@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(239, 49, 2, '', '', '00175', NULL, '', NULL, '@gmail.com.51@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(240, 49, 2, '', '', '00176', NULL, '', NULL, '@gmail.com.52@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(241, 49, 2, '', '', '00177', NULL, '', NULL, '@gmail.com.53@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(242, 49, 2, '', '', '00178', NULL, '', NULL, '@gmail.com.54@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(243, 49, 2, '', '', '00179', NULL, '', NULL, '@gmail.com.55@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(244, 49, 2, '', '', '00180', NULL, '', NULL, '@gmail.com.56@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(245, 49, 2, '', '', '00181', NULL, '', NULL, '@gmail.com.57@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(246, 49, 2, '', '', '00182', NULL, '', NULL, '@gmail.com.58@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(247, 49, 2, '', '', '00183', NULL, '', NULL, '@gmail.com.59@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(248, 49, 2, '', '', '00184', NULL, '', NULL, '@gmail.com.60@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(249, 49, 2, '', '', '00185', NULL, '', NULL, '@gmail.com.61@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(250, 49, 2, '', '', '00186', NULL, '', NULL, '@gmail.com.62@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(251, 49, 2, '', '', '00187', NULL, '', NULL, '@gmail.com.63@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(252, 49, 2, '', '', '00188', NULL, '', NULL, '@gmail.com.64@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(253, 49, 2, '', '', '00189', NULL, '', NULL, '@gmail.com.65@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(254, 49, 2, '', '', '00190', NULL, '', NULL, '@gmail.com.66@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(255, 49, 2, '', '', '00191', NULL, '', NULL, '@gmail.com.67@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(256, 49, 2, '', '', '00192', NULL, '', NULL, '@gmail.com.68@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(257, 49, 2, '', '', '00193', NULL, '', NULL, '@gmail.com.69@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(258, 49, 2, '', '', '00194', NULL, '', NULL, '@gmail.com.70@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(259, 49, 2, '', '', '00195', NULL, '', NULL, '@gmail.com.71@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(260, 49, 2, '', '', '00196', NULL, '', NULL, '@gmail.com.72@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(261, 49, 2, '', '', '00197', NULL, '', NULL, '@gmail.com.73@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(262, 49, 2, '', '', '00198', NULL, '', NULL, '@gmail.com.74@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(263, 49, 2, '', '', '00199', NULL, '', NULL, '@gmail.com.75@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(264, 49, 2, '', '', '00200', NULL, '', NULL, '@gmail.com.76@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(265, 49, 2, '', '', '00201', NULL, '', NULL, '@gmail.com.77@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(266, 49, 2, '', '', '00202', NULL, '', NULL, '@gmail.com.78@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(267, 49, 2, '', '', '00203', NULL, '', NULL, '@gmail.com.79@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(268, 49, 2, '', '', '00204', NULL, '', NULL, '@gmail.com.80@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(269, 49, 2, '', '', '00205', NULL, '', NULL, '@gmail.com.81@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(270, 49, 2, '', '', '00206', NULL, '', NULL, '@gmail.com.82@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(271, 49, 2, '', '', '00207', NULL, '', NULL, '@gmail.com.83@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(272, 49, 2, '', '', '00208', NULL, '', NULL, '@gmail.com.84@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(273, 49, 2, '', '', '00209', NULL, '', NULL, '@gmail.com.85@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(274, 49, 2, '', '', '00210', NULL, '', NULL, '@gmail.com.86@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(275, 49, 2, '', '', '00211', NULL, '', NULL, '@gmail.com.87@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(276, 49, 2, '', '', '00212', NULL, '', NULL, '@gmail.com.88@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(277, 49, 2, '', '', '00213', NULL, '', NULL, '@gmail.com.89@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(278, 49, 2, '', '', '00214', NULL, '', NULL, '@gmail.com.90@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(279, 49, 2, '', '', '00215', NULL, '', NULL, '@gmail.com.91@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(280, 49, 2, '', '', '00216', NULL, '', NULL, '@gmail.com.92@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(281, 49, 2, '', '', '00217', NULL, '', NULL, '@gmail.com.93@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(282, 49, 2, '', '', '00218', NULL, '', NULL, '@gmail.com.94@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(283, 49, 2, '', '', '00219', NULL, '', NULL, '@gmail.com.95@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(284, 49, 2, '', '', '00220', NULL, '', NULL, '@gmail.com.96@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(285, 49, 2, '', '', '00221', NULL, '', NULL, '@gmail.com.97@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(286, 49, 2, '', '', '00222', NULL, '', NULL, '@gmail.com.98@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(287, 49, 2, '', '', '00223', NULL, '', NULL, '@gmail.com.99@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(288, 49, 2, '', '', '00224', NULL, '', NULL, '@gmail.com.100@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(289, 49, 2, '', '', '00225', NULL, '', NULL, '@gmail.com.101@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(290, 49, 2, '', '', '00226', NULL, '', NULL, '@gmail.com.102@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(291, 49, 2, '', '', '00227', NULL, '', NULL, '@gmail.com.103@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(292, 49, 2, '', '', '00228', NULL, '', NULL, '@gmail.com.104@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(293, 49, 2, '', '', '00229', NULL, '', NULL, '@gmail.com.105@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(294, 49, 2, '', '', '00230', NULL, '', NULL, '@gmail.com.106@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(295, 49, 2, '', '', '00231', NULL, '', NULL, '@gmail.com.107@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(296, 49, 2, '', '', '00232', NULL, '', NULL, '@gmail.com.108@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(297, 49, 2, '', '', '00233', NULL, '', NULL, '@gmail.com.109@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(298, 49, 2, '', '', '00234', NULL, '', NULL, '@gmail.com.110@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(299, 49, 2, '', '', '00235', NULL, '', NULL, '@gmail.com.111@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(300, 49, 2, '', '', '00236', NULL, '', NULL, '@gmail.com.112@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(301, 49, 2, '', '', '00237', NULL, '', NULL, '@gmail.com.113@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(302, 49, 2, '', '', '00238', NULL, '', NULL, '@gmail.com.114@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(303, 49, 2, '', '', '00239', NULL, '', NULL, '@gmail.com.115@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(304, 49, 2, '', '', '00240', NULL, '', NULL, '@gmail.com.116@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(305, 49, 2, '', '', '00241', NULL, '', NULL, '@gmail.com.117@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(306, 49, 2, '', '', '00242', NULL, '', NULL, '@gmail.com.118@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(307, 49, 2, '', '', '00243', NULL, '', NULL, '@gmail.com.119@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(308, 49, 2, '', '', '00244', NULL, '', NULL, '@gmail.com.120@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(309, 49, 2, '', '', '00245', NULL, '', NULL, '@gmail.com.121@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(310, 49, 2, '', '', '00246', NULL, '', NULL, '@gmail.com.122@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(311, 49, 2, '', '', '00247', NULL, '', NULL, '@gmail.com.123@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(312, 49, 2, '', '', '00248', NULL, '', NULL, '@gmail.com.124@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(313, 49, 2, '', '', '00249', NULL, '', NULL, '@gmail.com.125@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(314, 49, 2, '', '', '00250', NULL, '', NULL, '@gmail.com.126@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(315, 49, 2, '', '', '00251', NULL, '', NULL, '@gmail.com.127@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(316, 49, 2, '', '', '00252', NULL, '', NULL, '@gmail.com.128@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(317, 49, 2, '', '', '00253', NULL, '', NULL, '@gmail.com.129@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(318, 49, 2, '', '', '00254', NULL, '', NULL, '@gmail.com.130@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(319, 49, 2, '', '', '00255', NULL, '', NULL, '@gmail.com.131@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(320, 49, 2, '', '', '00256', NULL, '', NULL, '@gmail.com.132@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(321, 49, 2, '', '', '00257', NULL, '', NULL, '@gmail.com.133@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(322, 49, 2, '', '', '00258', NULL, '', NULL, '@gmail.com.134@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(323, 49, 2, '', '', '00259', NULL, '', NULL, '@gmail.com.135@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(324, 49, 2, '', '', '00260', NULL, '', NULL, '@gmail.com.136@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(325, 49, 2, '', '', '00261', NULL, '', NULL, '@gmail.com.137@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(326, 49, 2, '', '', '00262', NULL, '', NULL, '@gmail.com.138@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(327, 49, 2, '', '', '00263', NULL, '', NULL, '@gmail.com.139@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(328, 49, 2, '', '', '00264', NULL, '', NULL, '@gmail.com.140@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(329, 49, 2, '', '', '00265', NULL, '', NULL, '@gmail.com.141@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(330, 49, 2, '', '', '00266', NULL, '', NULL, '@gmail.com.142@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(331, 49, 2, '', '', '00267', NULL, '', NULL, '@gmail.com.143@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(332, 49, 2, '', '', '00268', NULL, '', NULL, '@gmail.com.144@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(333, 49, 2, '', '', '00269', NULL, '', NULL, '@gmail.com.145@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(334, 49, 2, '', '', '00270', NULL, '', NULL, '@gmail.com.146@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(335, 49, 2, '', '', '00271', NULL, '', NULL, '@gmail.com.147@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(336, 49, 2, '', '', '00272', NULL, '', NULL, '@gmail.com.148@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(337, 49, 2, '', '', '00273', NULL, '', NULL, '@gmail.com.149@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(338, 49, 2, '', '', '00274', NULL, '', NULL, '@gmail.com.150@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(339, 49, 2, '', '', '00275', NULL, '', NULL, '@gmail.com.151@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(340, 49, 2, '', '', '00276', NULL, '', NULL, '@gmail.com.152@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(341, 49, 2, '', '', '00277', NULL, '', NULL, '@gmail.com.153@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(342, 49, 2, '', '', '00278', NULL, '', NULL, '@gmail.com.154@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(343, 49, 2, '', '', '00279', NULL, '', NULL, '@gmail.com.155@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(344, 49, 2, '', '', '00280', NULL, '', NULL, '@gmail.com.156@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(345, 49, 2, '', '', '00281', NULL, '', NULL, '@gmail.com.157@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(346, 49, 2, '', '', '00282', NULL, '', NULL, '@gmail.com.158@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(347, 49, 2, '', '', '00283', NULL, '', NULL, '@gmail.com.159@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(348, 49, 2, '', '', '00284', NULL, '', NULL, '@gmail.com.160@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(349, 49, 2, '', '', '00285', NULL, '', NULL, '@gmail.com.161@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(350, 49, 2, '', '', '00286', NULL, '', NULL, '@gmail.com.162@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(351, 49, 2, '', '', '00287', NULL, '', NULL, '@gmail.com.163@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1);
INSERT INTO `account_ledgers` (`id`, `_account_group_id`, `_account_head_id`, `_name`, `_alious`, `_code`, `_image`, `_nid`, `_other_document`, `_email`, `_phone`, `_address`, `_credit_limit`, `_balance`, `_branch_id`, `_is_user`, `_user_id`, `_is_sales_form`, `_is_purchase_form`, `_is_all_branch`, `_short`, `_status`, `_is_used`, `_show`, `_note`, `opening_dr_amount`, `opening_cr_amount`, `_created_by`, `_updated_by`, `created_at`, `updated_at`, `_main_account_id`, `_acc_head_pl3_id`, `_acc_head_pl2_id`, `_nidimage`, `_checkpage_image`, `_designation`, `_specialist`, `_address_2`, `_date_of_birth`, `_whatsup_number`, `_reg_no`, `organization_id`, `_cost_center_id`) VALUES
(352, 49, 2, '', '', '00288', NULL, '', NULL, '@gmail.com.164@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(353, 49, 2, '', '', '00289', NULL, '', NULL, '@gmail.com.165@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(354, 49, 2, '', '', '00290', NULL, '', NULL, '@gmail.com.166@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(355, 49, 2, '', '', '00291', NULL, '', NULL, '@gmail.com.167@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(356, 49, 2, '', '', '00292', NULL, '', NULL, '@gmail.com.168@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(357, 49, 2, '', '', '00293', NULL, '', NULL, '@gmail.com.169@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(358, 49, 2, '', '', '00294', NULL, '', NULL, '@gmail.com.170@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(359, 49, 2, '', '', '00295', NULL, '', NULL, '@gmail.com.171@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(360, 49, 2, '', '', '00296', NULL, '', NULL, '@gmail.com.172@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(361, 49, 2, '', '', '00297', NULL, '', NULL, '@gmail.com.173@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(362, 49, 2, '', '', '00298', NULL, '', NULL, '@gmail.com.174@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(363, 49, 2, '', '', '00299', NULL, '', NULL, '@gmail.com.175@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(364, 49, 2, '', '', '00300', NULL, '', NULL, '@gmail.com.176@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(365, 49, 2, '', '', '00301', NULL, '', NULL, '@gmail.com.177@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(366, 49, 2, '', '', '00302', NULL, '', NULL, '@gmail.com.178@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(367, 49, 2, '', '', '00303', NULL, '', NULL, '@gmail.com.179@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(368, 49, 2, '', '', '00304', NULL, '', NULL, '@gmail.com.180@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(369, 49, 2, '', '', '00305', NULL, '', NULL, '@gmail.com.181@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(370, 49, 2, '', '', '00306', NULL, '', NULL, '@gmail.com.182@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(371, 49, 2, '', '', '00307', NULL, '', NULL, '@gmail.com.183@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(372, 49, 2, '', '', '00308', NULL, '', NULL, '@gmail.com.184@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(373, 49, 2, '', '', '00309', NULL, '', NULL, '@gmail.com.185@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(374, 49, 2, '', '', '00310', NULL, '', NULL, '@gmail.com.186@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(375, 49, 2, '', '', '00311', NULL, '', NULL, '@gmail.com.187@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(376, 49, 2, '', '', '00312', NULL, '', NULL, '@gmail.com.188@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(377, 49, 2, '', '', '00313', NULL, '', NULL, '@gmail.com.189@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(378, 49, 2, '', '', '00314', NULL, '', NULL, '@gmail.com.190@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(379, 49, 2, '', '', '00315', NULL, '', NULL, '@gmail.com.191@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(380, 49, 2, '', '', '00316', NULL, '', NULL, '@gmail.com.192@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(381, 49, 2, '', '', '00317', NULL, '', NULL, '@gmail.com.193@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(382, 49, 2, '', '', '00318', NULL, '', NULL, '@gmail.com.194@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(383, 49, 2, '', '', '00319', NULL, '', NULL, '@gmail.com.195@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(384, 49, 2, '', '', '00320', NULL, '', NULL, '@gmail.com.196@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(385, 49, 2, '', '', '00321', NULL, '', NULL, '@gmail.com.197@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(386, 49, 2, '', '', '00322', NULL, '', NULL, '@gmail.com.198@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(387, 49, 2, '', '', '00323', NULL, '', NULL, '@gmail.com.199@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(388, 49, 2, '', '', '00324', NULL, '', NULL, '@gmail.com.200@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(389, 49, 2, '', '', '00325', NULL, '', NULL, '@gmail.com.201@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(390, 49, 2, '', '', '00326', NULL, '', NULL, '@gmail.com.202@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(391, 49, 2, '', '', '00327', NULL, '', NULL, '@gmail.com.203@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(392, 49, 2, '', '', '00328', NULL, '', NULL, '@gmail.com.204@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(393, 49, 2, '', '', '00329', NULL, '', NULL, '@gmail.com.205@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(394, 49, 2, '', '', '00330', NULL, '', NULL, '@gmail.com.206@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(395, 49, 2, '', '', '00331', NULL, '', NULL, '@gmail.com.207@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(396, 49, 2, '', '', '00332', NULL, '', NULL, '@gmail.com.208@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(397, 49, 2, '', '', '00333', NULL, '', NULL, '@gmail.com.209@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(398, 49, 2, '', '', '00334', NULL, '', NULL, '@gmail.com.210@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(399, 49, 2, '', '', '00335', NULL, '', NULL, '@gmail.com.211@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(400, 49, 2, '', '', '00336', NULL, '', NULL, '@gmail.com.212@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(401, 49, 2, '', '', '00337', NULL, '', NULL, '@gmail.com.213@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(402, 49, 2, '', '', '00338', NULL, '', NULL, '@gmail.com.214@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(403, 49, 2, '', '', '00339', NULL, '', NULL, '@gmail.com.215@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(404, 49, 2, '', '', '00340', NULL, '', NULL, '@gmail.com.216@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(405, 49, 2, '', '', '00341', NULL, '', NULL, '@gmail.com.217@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(406, 49, 2, '', '', '00342', NULL, '', NULL, '@gmail.com.218@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(407, 49, 2, '', '', '00343', NULL, '', NULL, '@gmail.com.219@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(408, 49, 2, '', '', '00344', NULL, '', NULL, '@gmail.com.220@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(409, 49, 2, '', '', '00345', NULL, '', NULL, '@gmail.com.221@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(410, 49, 2, '', '', '00346', NULL, '', NULL, '@gmail.com.222@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(411, 49, 2, '', '', '00347', NULL, '', NULL, '@gmail.com.223@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(412, 49, 2, '', '', '00348', NULL, '', NULL, '@gmail.com.224@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(413, 49, 2, '', '', '00349', NULL, '', NULL, '@gmail.com.225@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(414, 49, 2, '', '', '00350', NULL, '', NULL, '@gmail.com.226@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(415, 49, 2, '', '', '00351', NULL, '', NULL, '@gmail.com.227@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(416, 49, 2, '', '', '00352', NULL, '', NULL, '@gmail.com.228@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(417, 49, 2, '', '', '00353', NULL, '', NULL, '@gmail.com.229@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(418, 49, 2, '', '', '00354', NULL, '', NULL, '@gmail.com.230@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(419, 49, 2, '', '', '00355', NULL, '', NULL, '@gmail.com.231@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(420, 49, 2, '', '', '00356', NULL, '', NULL, '@gmail.com.232@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(421, 49, 2, '', '', '00357', NULL, '', NULL, '@gmail.com.233@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(422, 49, 2, '', '', '00358', NULL, '', NULL, '@gmail.com.234@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(423, 49, 2, '', '', '00359', NULL, '', NULL, '@gmail.com.235@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(424, 49, 2, '', '', '00360', NULL, '', NULL, '@gmail.com.236@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(425, 49, 2, '', '', '00361', NULL, '', NULL, '@gmail.com.237@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(426, 49, 2, '', '', '00362', NULL, '', NULL, '@gmail.com.238@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(427, 49, 2, '', '', '00363', NULL, '', NULL, '@gmail.com.239@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(428, 49, 2, '', '', '00364', NULL, '', NULL, '@gmail.com.240@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(429, 49, 2, '', '', '00365', NULL, '', NULL, '@gmail.com.241@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(430, 49, 2, '', '', '00366', NULL, '', NULL, '@gmail.com.242@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(431, 49, 2, '', '', '00367', NULL, '', NULL, '@gmail.com.243@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(432, 49, 2, '', '', '00368', NULL, '', NULL, '@gmail.com.244@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(433, 49, 2, '', '', '00369', NULL, '', NULL, '@gmail.com.245@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(434, 49, 2, '', '', '00370', NULL, '', NULL, '@gmail.com.246@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(435, 49, 2, '', '', '00371', NULL, '', NULL, '@gmail.com.247@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(436, 49, 2, '', '', '00372', NULL, '', NULL, '@gmail.com.248@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(437, 49, 2, '', '', '00373', NULL, '', NULL, '@gmail.com.249@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(438, 49, 2, '', '', '00374', NULL, '', NULL, '@gmail.com.250@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(439, 49, 2, '', '', '00375', NULL, '', NULL, '@gmail.com.251@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(440, 49, 2, '', '', '00376', NULL, '', NULL, '@gmail.com.252@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(441, 49, 2, '', '', '00377', NULL, '', NULL, '@gmail.com.253@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(442, 49, 2, '', '', '00378', NULL, '', NULL, '@gmail.com.254@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(443, 49, 2, '', '', '00379', NULL, '', NULL, '@gmail.com.255@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(444, 49, 2, '', '', '00380', NULL, '', NULL, '@gmail.com.256@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(445, 49, 2, '', '', '00381', NULL, '', NULL, '@gmail.com.257@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(446, 49, 2, '', '', '00382', NULL, '', NULL, '@gmail.com.258@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(447, 49, 2, '', '', '00383', NULL, '', NULL, '@gmail.com.259@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(448, 49, 2, '', '', '00384', NULL, '', NULL, '@gmail.com.260@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(449, 49, 2, '', '', '00385', NULL, '', NULL, '@gmail.com.261@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(450, 49, 2, '', '', '00386', NULL, '', NULL, '@gmail.com.262@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(451, 49, 2, '', '', '00387', NULL, '', NULL, '@gmail.com.263@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(452, 49, 2, '', '', '00388', NULL, '', NULL, '@gmail.com.264@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(453, 49, 2, '', '', '00389', NULL, '', NULL, '@gmail.com.265@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(454, 49, 2, '', '', '00390', NULL, '', NULL, '@gmail.com.266@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(455, 49, 2, '', '', '00391', NULL, '', NULL, '@gmail.com.267@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(456, 49, 2, '', '', '00392', NULL, '', NULL, '@gmail.com.268@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(457, 49, 2, '', '', '00393', NULL, '', NULL, '@gmail.com.269@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(458, 49, 2, '', '', '00394', NULL, '', NULL, '@gmail.com.270@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(459, 49, 2, '', '', '00395', NULL, '', NULL, '@gmail.com.271@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(460, 49, 2, '', '', '00396', NULL, '', NULL, '@gmail.com.272@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(461, 49, 2, '', '', '00397', NULL, '', NULL, '@gmail.com.273@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(462, 49, 2, '', '', '00398', NULL, '', NULL, '@gmail.com.274@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(463, 49, 2, '', '', '00399', NULL, '', NULL, '@gmail.com.275@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(464, 49, 2, '', '', '00400', NULL, '', NULL, '@gmail.com.276@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(465, 49, 2, '', '', '00401', NULL, '', NULL, '@gmail.com.277@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(466, 49, 2, '', '', '00402', NULL, '', NULL, '@gmail.com.278@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(467, 49, 2, '', '', '00403', NULL, '', NULL, '@gmail.com.279@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(468, 49, 2, '', '', '00404', NULL, '', NULL, '@gmail.com.280@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(469, 49, 2, '', '', '00405', NULL, '', NULL, '@gmail.com.281@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(470, 49, 2, '', '', '00406', NULL, '', NULL, '@gmail.com.282@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(471, 49, 2, '', '', '00407', NULL, '', NULL, '@gmail.com.283@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(472, 49, 2, '', '', '00408', NULL, '', NULL, '@gmail.com.284@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(473, 49, 2, '', '', '00409', NULL, '', NULL, '@gmail.com.285@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(474, 49, 2, '', '', '00410', NULL, '', NULL, '@gmail.com.286@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(475, 49, 2, '', '', '00411', NULL, '', NULL, '@gmail.com.287@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(476, 49, 2, '', '', '00412', NULL, '', NULL, '@gmail.com.288@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(477, 49, 2, '', '', '00413', NULL, '', NULL, '@gmail.com.289@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(478, 49, 2, '', '', '00414', NULL, '', NULL, '@gmail.com.290@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(479, 49, 2, '', '', '00415', NULL, '', NULL, '@gmail.com.291@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(480, 49, 2, '', '', '00416', NULL, '', NULL, '@gmail.com.292@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(481, 49, 2, '', '', '00417', NULL, '', NULL, '@gmail.com.293@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(482, 49, 2, '', '', '00418', NULL, '', NULL, '@gmail.com.294@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(483, 49, 2, '', '', '00419', NULL, '', NULL, '@gmail.com.295@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(484, 49, 2, '', '', '00420', NULL, '', NULL, '@gmail.com.296@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(485, 49, 2, '', '', '00421', NULL, '', NULL, '@gmail.com.297@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(486, 49, 2, '', '', '00422', NULL, '', NULL, '@gmail.com.298@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(487, 49, 2, '', '', '00423', NULL, '', NULL, '@gmail.com.299@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(488, 49, 2, '', '', '00424', NULL, '', NULL, '@gmail.com.300@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(489, 49, 2, '', '', '00425', NULL, '', NULL, '@gmail.com.301@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(490, 49, 2, '', '', '00426', NULL, '', NULL, '@gmail.com.302@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(491, 49, 2, '', '', '00427', NULL, '', NULL, '@gmail.com.303@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(492, 49, 2, '', '', '00428', NULL, '', NULL, '@gmail.com.304@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(493, 49, 2, '', '', '00429', NULL, '', NULL, '@gmail.com.305@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(494, 49, 2, '', '', '00430', NULL, '', NULL, '@gmail.com.306@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(495, 49, 2, '', '', '00431', NULL, '', NULL, '@gmail.com.307@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(496, 49, 2, '', '', '00432', NULL, '', NULL, '@gmail.com.308@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(497, 49, 2, '', '', '00433', NULL, '', NULL, '@gmail.com.309@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(498, 49, 2, '', '', '00434', NULL, '', NULL, '@gmail.com.310@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(499, 49, 2, '', '', '00435', NULL, '', NULL, '@gmail.com.311@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(500, 49, 2, '', '', '00436', NULL, '', NULL, '@gmail.com.312@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(501, 49, 2, '', '', '00437', NULL, '', NULL, '@gmail.com.313@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(502, 49, 2, '', '', '00438', NULL, '', NULL, '@gmail.com.314@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(503, 49, 2, '', '', '00439', NULL, '', NULL, '@gmail.com.315@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(504, 49, 2, '', '', '00440', NULL, '', NULL, '@gmail.com.316@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(505, 49, 2, '', '', '00441', NULL, '', NULL, '@gmail.com.317@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(506, 49, 2, '', '', '00442', NULL, '', NULL, '@gmail.com.318@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(507, 49, 2, '', '', '00443', NULL, '', NULL, '@gmail.com.319@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(508, 49, 2, '', '', '00444', NULL, '', NULL, '@gmail.com.320@gmail.com', '', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 1, 1, 1, '', 0, 0, '49-Shihab', NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04', 1, 0, 0, NULL, NULL, NULL, NULL, '', '0000-00-00', NULL, NULL, 1, 1),
(509, 49, 2, 'MD. Waliulla', 'Md. Elias Hossen', '00445', NULL, '20094110915108143', NULL, '', '01720-356536', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 0, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-22 16:07:05', '2025-05-22 16:28:12', 1, 0, 0, NULL, NULL, NULL, NULL, '', '2009-01-31', NULL, NULL, 1, 1),
(510, 49, 2, 'Omar Gazi', 'রাজু গাজি', '00446', NULL, '20094114741052600', NULL, '', '01966994761', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 0, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-22 16:34:00', '2025-05-25 11:13:04', 1, 0, 0, NULL, NULL, NULL, NULL, '', '2009-01-05', NULL, NULL, 1, 1),
(511, 49, 2, 'Farhad', 'রাজু গাজি', 'SIEL-000005', NULL, '20094114741052600', NULL, '', '01966994761', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 0, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-22 16:34:00', '2025-05-25 11:13:04', 1, 0, 0, NULL, NULL, NULL, NULL, '', '2009-01-05', NULL, NULL, 1, 1),
(512, 49, 2, 'Polash', 'Polash', 'SIEL-000002', NULL, '20094114741052600', NULL, '', '01966994761', '', 0.0000, 0.0000, 1, 1, 0, 0, 0, 0, 5, 0, 1, 1, '', 0, 0, '46-Admin', NULL, '2025-05-22 16:34:00', '2025-05-25 11:13:04', 1, 0, 0, NULL, NULL, NULL, NULL, '', '2009-01-05', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `assets_conditions`
--

CREATE TABLE `assets_conditions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(60) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets_device_locations`
--

CREATE TABLE `assets_device_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(60) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets_locations`
--

CREATE TABLE `assets_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_assigns`
--

CREATE TABLE `asset_assigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_item_id` int(11) NOT NULL DEFAULT 0,
  `asset_category_id` int(11) NOT NULL DEFAULT 0,
  `assign_unique_serial` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `dept_id` int(11) NOT NULL DEFAULT 0,
  `designation_id` int(11) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `asset_user_id` int(11) NOT NULL DEFAULT 0,
  `asset_location_id` int(11) NOT NULL DEFAULT 0,
  `asset_room_id` int(11) NOT NULL DEFAULT 0,
  `asset_floor` varchar(255) DEFAULT NULL,
  `assign_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `assign_remarks` longtext DEFAULT NULL,
  `inspection_remarks` longtext DEFAULT NULL,
  `inspection_date` date DEFAULT NULL,
  `inspector_information` longtext DEFAULT NULL,
  `assign_status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `assign_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_depreciations`
--

CREATE TABLE `asset_depreciations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_voucher_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(100) DEFAULT NULL,
  `_date` date NOT NULL,
  `_end_date` date DEFAULT NULL,
  `_dep_month` int(11) NOT NULL DEFAULT 0,
  `_dep_year` int(11) NOT NULL DEFAULT 0,
  `_total_amount` double NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_depreciation_details`
--

CREATE TABLE `asset_depreciation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_asset_id` int(11) NOT NULL DEFAULT 0,
  `asset_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_dep_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_dep_exp_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_asset_dep_rate` double NOT NULL DEFAULT 0,
  `_asset_dep_type` int(11) NOT NULL DEFAULT 0,
  `book_value` double NOT NULL DEFAULT 0,
  `_asset_dep_amount` double NOT NULL DEFAULT 0,
  `pre_accumulated_dep_val` double NOT NULL DEFAULT 0,
  `accumulated_dep_val` double NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_eng_consumptions`
--

CREATE TABLE `asset_eng_consumptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_voucher_number` varchar(255) DEFAULT NULL,
  `_voucher_code` varchar(100) DEFAULT NULL,
  `_voucher_id` int(11) NOT NULL DEFAULT 0,
  `_expense_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_payable_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_id` int(11) NOT NULL DEFAULT 0,
  `_date` date DEFAULT NULL,
  `energy_used` double NOT NULL DEFAULT 0,
  `cost` double NOT NULL DEFAULT 0,
  `operating_hours` double NOT NULL DEFAULT 0,
  `fuel_used_liters` double NOT NULL DEFAULT 0,
  `electricity_used_kwh` double NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_images`
--

CREATE TABLE `asset_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` int(11) NOT NULL DEFAULT 0,
  `asset_assign_id` int(11) NOT NULL DEFAULT 0,
  `image_1` varchar(255) DEFAULT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_import_costs`
--

CREATE TABLE `asset_import_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_purchase_type` varchar(255) DEFAULT NULL,
  `_voucher_number` text DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_order_number` varchar(255) DEFAULT NULL,
  `_supplier_name` varchar(255) DEFAULT NULL,
  `_bank_name` varchar(255) DEFAULT NULL,
  `_branch_name` varchar(255) DEFAULT NULL,
  `_lc_no` varchar(255) DEFAULT NULL,
  `_lc_date` date DEFAULT NULL,
  `_pi_no` varchar(255) DEFAULT NULL,
  `_pi_date` date DEFAULT NULL,
  `_invoice_no` varchar(255) DEFAULT NULL,
  `_invoice_date` date DEFAULT NULL,
  `_boe_no` varchar(255) DEFAULT NULL,
  `_boe_date` date DEFAULT NULL,
  `_bl_no` varchar(255) DEFAULT NULL,
  `_bl_date` date DEFAULT NULL,
  `_incoterms` varchar(255) DEFAULT NULL,
  `_import_currency` varchar(255) DEFAULT NULL,
  `_currency_rate` varchar(255) DEFAULT NULL,
  `_date_of_arrival` date DEFAULT NULL,
  `_procurement_officer` varchar(255) DEFAULT NULL,
  `_cnf_agent` varchar(255) DEFAULT NULL,
  `_cnf_agent_id` int(11) NOT NULL DEFAULT 0,
  `_date` date DEFAULT NULL,
  `_ammendment_date` date DEFAULT NULL,
  `_ammendment_reason` text DEFAULT NULL,
  `_bill_of_entry_no` varchar(255) DEFAULT NULL,
  `_note` text DEFAULT NULL,
  `_bill_of_entry_date` date DEFAULT NULL,
  `_import_cost_foreign` double NOT NULL DEFAULT 0,
  `_import_cost_local` double NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_total_qty` double NOT NULL DEFAULT 0,
  `_total_cfr_value_usd` double NOT NULL DEFAULT 0,
  `_total_cfr_value_bdt` double NOT NULL DEFAULT 0,
  `_total_insurance_bdt` double NOT NULL DEFAULT 0,
  `_total_lc_commision_bdt` double NOT NULL DEFAULT 0,
  `_total_custom_duty_bdt` double NOT NULL DEFAULT 0,
  `_total_other_cost_bdt` double NOT NULL DEFAULT 0,
  `_total_asset_value_bdt` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_import_cost_details`
--

CREATE TABLE `asset_import_cost_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_asset_category_id` int(11) NOT NULL DEFAULT 0,
  `_asset_name` varchar(255) DEFAULT NULL,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_rate_usd` double NOT NULL DEFAULT 0,
  `_cfr_value_usd` double NOT NULL DEFAULT 0,
  `_cfr_value_bdt` double NOT NULL DEFAULT 0,
  `_currency_rate_usd_to_bdt` double NOT NULL DEFAULT 0,
  `_insurance_bdt` double NOT NULL DEFAULT 0,
  `_lc_commision_bdt` double NOT NULL DEFAULT 0,
  `_custom_duty_bdt` double NOT NULL DEFAULT 0,
  `_rd` double NOT NULL DEFAULT 0,
  `_sd` double NOT NULL DEFAULT 0,
  `_vat` double NOT NULL DEFAULT 0,
  `_at` double NOT NULL DEFAULT 0,
  `_atv` double NOT NULL DEFAULT 0,
  `_custom_duty_tax_ait` double NOT NULL DEFAULT 0,
  `_custom_duty_tax_ait_2nd` double NOT NULL DEFAULT 0,
  `_customer_other_charge_other` double NOT NULL DEFAULT 0,
  `_port_charge` double NOT NULL DEFAULT 0,
  `_port_charge_ait` double NOT NULL DEFAULT 0,
  `_shiping_agent_charge` double NOT NULL DEFAULT 0,
  `_shiping_agent_deduction_charge_2nd` double NOT NULL DEFAULT 0,
  `_deport_charge` double NOT NULL DEFAULT 0,
  `_container_damage_charge` double NOT NULL DEFAULT 0,
  `_cnf_agen_commision` double NOT NULL DEFAULT 0,
  `_installation_cost` double NOT NULL DEFAULT 0,
  `_other_cost` double NOT NULL DEFAULT 0,
  `_total_initial_cost` double NOT NULL DEFAULT 0,
  `_salvage_value` double NOT NULL DEFAULT 0,
  `_depreciable_asset_value` double NOT NULL DEFAULT 0,
  `_cv` double NOT NULL DEFAULT 0,
  `_scv` double NOT NULL DEFAULT 0,
  `_df` double NOT NULL DEFAULT 0,
  `_itc` double NOT NULL DEFAULT 0,
  `_dfv` double NOT NULL DEFAULT 0,
  `_pf` double NOT NULL DEFAULT 0,
  `_remarks` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_other_cost_bdt` double NOT NULL DEFAULT 0,
  `_asset_value_bdt` double NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_inspections`
--

CREATE TABLE `asset_inspections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `asset_id` int(11) NOT NULL DEFAULT 0,
  `asset_user_id` int(11) NOT NULL DEFAULT 0,
  `assign_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `dept_id` int(11) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `inspection_date` date DEFAULT NULL,
  `inspect_list_id` int(11) NOT NULL DEFAULT 0,
  `assign_status` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `chek_list_chek` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `remarks` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_items`
--

CREATE TABLE `asset_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `asset_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_dep_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_dep_exp_ledger_id` int(11) NOT NULL DEFAULT 0,
  `brand_id` int(11) NOT NULL DEFAULT 0,
  `vendor_id` varchar(255) DEFAULT NULL,
  `asset_condition_id` int(11) NOT NULL DEFAULT 0,
  `assign_status_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `asset_location_id` int(11) NOT NULL DEFAULT 0,
  `asset_room_id` int(11) NOT NULL DEFAULT 0,
  `asset_code` varchar(255) DEFAULT NULL,
  `model_no` varchar(255) DEFAULT NULL,
  `serial_no` varchar(255) DEFAULT NULL,
  `group_serial_no` varchar(255) DEFAULT NULL,
  `domain_intune` varchar(255) DEFAULT NULL,
  `asset_image_1` varchar(255) DEFAULT NULL,
  `asset_image_2` varchar(255) DEFAULT NULL,
  `warranty_start_date` date DEFAULT NULL,
  `warranty_end_date` date DEFAULT NULL,
  `warranty_status` varchar(150) DEFAULT NULL,
  `os_type` varchar(255) DEFAULT NULL,
  `import_cost_detail_id` varchar(200) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `year_manufacture` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `purchase_voucher_no` varchar(255) DEFAULT NULL,
  `voucher_id` int(11) NOT NULL DEFAULT 0,
  `dep_date` date DEFAULT NULL,
  `purchase_price` double NOT NULL DEFAULT 0,
  `extra_cost` double NOT NULL DEFAULT 0,
  `entry_price` double NOT NULL DEFAULT 0,
  `evaluated_price` double NOT NULL DEFAULT 0,
  `dep_type` tinyint(4) NOT NULL DEFAULT 0,
  `dep_rate` double NOT NULL DEFAULT 0,
  `dep_value` double NOT NULL DEFAULT 0,
  `insured_amount` float NOT NULL DEFAULT 0,
  `annual_benefit` float NOT NULL DEFAULT 0,
  `utilization_rate` varchar(200) DEFAULT NULL,
  `risk_level` varchar(200) DEFAULT NULL,
  `service_agreement_expiry` date DEFAULT NULL,
  `compliance_status` varchar(200) DEFAULT NULL,
  `accumulated_dep_val` float NOT NULL DEFAULT 0,
  `book_value` double NOT NULL DEFAULT 0,
  `salvage_value` double NOT NULL DEFAULT 0,
  `_selling_value` double NOT NULL DEFAULT 0,
  `_pl_amount` double NOT NULL DEFAULT 0,
  `_sale_date` date DEFAULT NULL,
  `estimated_life` varchar(255) DEFAULT NULL,
  `asset_tag` longtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `remarks` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_sold` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_p_p_id` int(11) NOT NULL DEFAULT 0,
  `_from_table` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_maintainces`
--

CREATE TABLE `asset_maintainces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_voucher_number` varchar(255) DEFAULT NULL,
  `_voucher_code` varchar(60) DEFAULT NULL,
  `_voucher_id` int(11) NOT NULL DEFAULT 0,
  `_expense_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_payable_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_id` int(11) NOT NULL DEFAULT 0,
  `_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cost` double NOT NULL DEFAULT 0,
  `technician_name` text DEFAULT NULL,
  `_note` text DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_sales`
--

CREATE TABLE `asset_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_date` date DEFAULT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `voucher_id` int(11) NOT NULL DEFAULT 0,
  `voucher_code` varchar(255) DEFAULT NULL,
  `payment_method` enum('cash','credit') NOT NULL,
  `_asset_customer_id` int(11) NOT NULL DEFAULT 0,
  `_asset_id` int(11) NOT NULL DEFAULT 0,
  `asset_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_dep_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_dep_exp_ledger_id` int(11) NOT NULL DEFAULT 0,
  `gain_or_loss_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_payment_receive_id` int(11) NOT NULL DEFAULT 0,
  `original_cost` decimal(10,0) NOT NULL DEFAULT 0,
  `accumulated_depreciation` decimal(10,0) NOT NULL DEFAULT 0,
  `sale_price` decimal(10,0) NOT NULL DEFAULT 0,
  `book_value` decimal(10,0) NOT NULL DEFAULT 0,
  `gain_loss` decimal(10,0) NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assign_leaves`
--

CREATE TABLE `assign_leaves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_employee` int(11) NOT NULL DEFAULT 0,
  `_type` int(11) NOT NULL DEFAULT 0,
  `_start` date DEFAULT NULL,
  `_end` date DEFAULT NULL,
  `_note` text DEFAULT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assign_statuses`
--

CREATE TABLE `assign_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `event` varchar(255) NOT NULL,
  `auditable_type` varchar(255) NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` text DEFAULT NULL,
  `new_values` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(1023) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audits`
--

INSERT INTO `audits` (`id`, `user_type`, `user_id`, `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `url`, `ip_address`, `user_agent`, `tags`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 2, 'created', 'App\\Models\\HRM\\HrmAttendance', 4, '[]', '{\"_employee_id\":\"3\",\"_emp_id\":\"42-10\",\"_employee\":\"3\",\"organization_id\":0,\"_cost_center_id\":0,\"_branch_id\":1,\"_number\":0,\"_type\":1,\"_datetime\":\"2025-08-03\",\"in_time\":\"09:07\",\"out_time\":\"14:08\",\"remarks\":\"\",\"_user_id\":2,\"id\":4}', 'http://localhost:8080/tmm/public/attandance', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', NULL, '2025-08-03 08:08:11', '2025-08-03 08:08:11'),
(2, 'App\\Models\\User', 2, 'created', 'App\\Models\\HRM\\HrmAttendance', 5, '[]', '{\"_employee_id\":\"105\",\"_emp_id\":\"00051\",\"_employee\":\"105\",\"organization_id\":0,\"_cost_center_id\":0,\"_branch_id\":1,\"_number\":0,\"_type\":1,\"_datetime\":\"2025-08-03\",\"in_time\":\"14:17\",\"out_time\":\"17:17\",\"remarks\":\"\",\"_user_id\":2,\"id\":5}', 'http://localhost:8080/tmm/public/attandance', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', NULL, '2025-08-03 08:17:34', '2025-08-03 08:17:34'),
(3, 'App\\Models\\User', 2, 'created', 'App\\Models\\HRM\\HrmAttendance', 6, '[]', '{\"_employee_id\":\"49\",\"_emp_id\":\"42-11\",\"_employee\":\"49\",\"organization_id\":0,\"_cost_center_id\":0,\"_branch_id\":1,\"_number\":0,\"_type\":1,\"_datetime\":\"2025-08-03\",\"in_time\":\"14:20\",\"out_time\":\"18:20\",\"remarks\":\"\",\"_user_id\":2,\"id\":6}', 'http://localhost:8080/tmm/public/attandance', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', NULL, '2025-08-03 08:22:22', '2025-08-03 08:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `bank_check_infos`
--

CREATE TABLE `bank_check_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_check_no` varchar(255) NOT NULL,
  `_note` text DEFAULT NULL,
  `_is_used` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `barcode_details`
--

CREATE TABLE `barcode_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bonus_item_details`
--

CREATE TABLE `bonus_item_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_start_time` datetime NOT NULL,
  `_end_time` datetime NOT NULL,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(100) NOT NULL,
  `_code` varchar(50) NOT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_email` varchar(60) DEFAULT NULL,
  `_phone` varchar(20) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `order` double(15,4) NOT NULL DEFAULT 0.0000,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `_name`, `_code`, `_address`, `_date`, `_email`, `_phone`, `_status`, `_created_by`, `_updated_by`, `created_at`, `updated_at`, `status`, `order`, `is_delete`) VALUES
(1, 'Tarafder Model Madrasah', 'TMM', '', '2023-10-01', '', '', 1, '46-Admin', '46-Admin', '2023-11-09 09:41:47', '2025-04-23 12:18:09', 0, 0.0000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL,
  `_cost_center_id` int(11) NOT NULL,
  `_branch_id` int(11) NOT NULL,
  `_start_date` date DEFAULT NULL,
  `_end_date` date DEFAULT NULL,
  `budget_amount` double NOT NULL DEFAULT 0,
  `_remarks` longtext DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` int(11) NOT NULL,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_material_amount` double(16,4) NOT NULL DEFAULT 0.0000,
  `_income_amount` double(16,4) NOT NULL DEFAULT 0.0000,
  `_expense_amount` double(16,4) NOT NULL DEFAULT 0.0000,
  `_project_value` double(16,4) NOT NULL DEFAULT 0.0000,
  `_name` varchar(255) DEFAULT NULL,
  `_customer_id` int(11) NOT NULL DEFAULT 0,
  `_po_order` varchar(150) DEFAULT NULL,
  `_wo_order` varchar(150) DEFAULT NULL,
  `_short_work_detail` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget_details`
--

CREATE TABLE `budget_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_budget_id` int(11) NOT NULL,
  `_ledger_id` int(11) NOT NULL,
  `_ledger_type` varchar(255) NOT NULL COMMENT 'Income,Expenses',
  `_short_narr` varchar(255) DEFAULT NULL,
  `_budget_amount` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget_item_details`
--

CREATE TABLE `budget_item_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_budget_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_item_unit_id` int(11) NOT NULL DEFAULT 0,
  `_item_type` varchar(255) DEFAULT NULL COMMENT 'Row,FG',
  `_item_qty` double NOT NULL DEFAULT 0,
  `_item_unit_price` double NOT NULL DEFAULT 0,
  `_item_budget_amount` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget_revisions`
--

CREATE TABLE `budget_revisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL,
  `_cost_center_id` int(11) NOT NULL,
  `_branch_id` int(11) NOT NULL,
  `_budget_id` int(11) NOT NULL,
  `_revision_date` date NOT NULL,
  `reason_for_revision` longtext DEFAULT NULL,
  `budget_amount` double NOT NULL DEFAULT 0,
  `_remarks` longtext DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` int(11) NOT NULL,
  `_user_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget_revision_details`
--

CREATE TABLE `budget_revision_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_budget_id` int(11) NOT NULL,
  `_budget_revision_id` int(11) NOT NULL,
  `_ledger_id` int(11) NOT NULL,
  `_ledger_type` varchar(255) NOT NULL COMMENT 'Account Ledger and inventory',
  `_budget_amount` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget_revision_item_details`
--

CREATE TABLE `budget_revision_item_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_budget_id` int(11) NOT NULL,
  `_budget_revision_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_item_unit_id` int(11) NOT NULL DEFAULT 0,
  `_item_type` varchar(255) DEFAULT NULL COMMENT 'Row,FG',
  `_item_qty` double NOT NULL DEFAULT 0,
  `_item_unit_price` double NOT NULL DEFAULT 0,
  `_item_budget_amount` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cat_wise_ta_bills`
--

CREATE TABLE `cat_wise_ta_bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_fescal_year` varchar(255) DEFAULT NULL,
  `_designation_id` int(11) NOT NULL DEFAULT 0,
  `_da_bill` double NOT NULL DEFAULT 0,
  `_moto_bill` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_code` varchar(50) DEFAULT NULL,
  `_name` varchar(255) NOT NULL,
  `_details` longtext DEFAULT NULL,
  `_bin` varchar(255) DEFAULT NULL,
  `_address` longtext DEFAULT NULL,
  `_status` int(11) NOT NULL,
  `_user` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double(15,4) NOT NULL DEFAULT 0.0000,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `_code`, `_name`, `_details`, `_bin`, `_address`, `_status`, `_user`, `created_at`, `updated_at`, `is_delete`, `order`, `status`) VALUES
(1, 'TMM', 'Tarafder Model Madrasah', '', '002578873-0101', '72, Mohakhali C/A,Rupayan Centre(8th Floor),Dhaka-1212,Bangladesh', 1, 46, '2023-11-09 09:35:07', '2025-04-23 12:05:19', 0, 0.0000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cost_centers`
--

CREATE TABLE `cost_centers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) NOT NULL,
  `_start_date` date DEFAULT NULL,
  `_end_date` date DEFAULT NULL,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_detail` longtext DEFAULT NULL,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `_created_by` varchar(150) DEFAULT NULL,
  `_updated_by` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double(15,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cost_centers`
--

INSERT INTO `cost_centers` (`id`, `_name`, `_code`, `_start_date`, `_end_date`, `_branch_id`, `organization_id`, `_detail`, `_is_close`, `_status`, `_created_by`, `_updated_by`, `created_at`, `updated_at`, `status`, `is_delete`, `order`) VALUES
(1, 'TMM', '', NULL, NULL, 0, 0, NULL, 0, 1, NULL, NULL, NULL, NULL, 0, 0, 0.0000);

-- --------------------------------------------------------

--
-- Table structure for table `cost_center_authorised_chains`
--

CREATE TABLE `cost_center_authorised_chains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL,
  `_branch_id` int(11) NOT NULL,
  `_cost_center_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_name` varchar(255) DEFAULT NULL,
  `erp_user_id` varchar(255) DEFAULT NULL,
  `erp_user_name` varchar(255) DEFAULT NULL,
  `ack_order` double NOT NULL DEFAULT 0,
  `ack_status` int(11) NOT NULL DEFAULT 0,
  `is_visible` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `ack_request_date` date DEFAULT NULL,
  `ack_updated_date` date DEFAULT NULL,
  `_status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `countrycode` varchar(255) NOT NULL,
  `countryname` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `language_code` varchar(255) DEFAULT NULL,
  `language_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `countrycode`, `countryname`, `code`, `language_code`, `language_name`, `created_at`, `updated_at`) VALUES
(2, 'Bangladesh', 'Bangladesh', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `current_salary_masters`
--

CREATE TABLE `current_salary_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_employee_id` int(11) NOT NULL,
  `_employee_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_emp_code` varchar(255) DEFAULT NULL,
  `total_earnings` double NOT NULL DEFAULT 0,
  `total_deduction` double NOT NULL DEFAULT 0,
  `net_total_earning` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `current_salary_masters`
--

INSERT INTO `current_salary_masters` (`id`, `_employee_id`, `_employee_ledger_id`, `_emp_code`, `total_earnings`, `total_deduction`, `net_total_earning`, `_status`, `_is_delete`, `created_at`, `updated_at`) VALUES
(1, 499, 23, 'IEL-000007', 62850, 910, 61940, 1, 0, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(2, 12, 39, '42-1', 0, 0, 0, 1, 0, '2025-05-16 09:33:39', '2025-05-16 09:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `current_salary_structures`
--

CREATE TABLE `current_salary_structures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_master_id` int(11) NOT NULL DEFAULT 0,
  `_employee_id` int(11) NOT NULL,
  `_emp_code` varchar(100) DEFAULT NULL,
  `_employee_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_payhead_id` int(11) NOT NULL,
  `_payhead_type_id` int(11) NOT NULL DEFAULT 0,
  `_amount` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `current_salary_structures`
--

INSERT INTO `current_salary_structures` (`id`, `_master_id`, `_employee_id`, `_emp_code`, `_employee_ledger_id`, `_payhead_id`, `_payhead_type_id`, `_amount`, `_status`, `created_at`, `updated_at`) VALUES
(1, 1, 499, 'IEL-000007', 23, 1, 1, 25000, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(2, 1, 499, 'IEL-000007', 23, 2, 1, 12600, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(3, 1, 499, 'IEL-000007', 23, 3, 1, 4400, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(4, 1, 499, 'IEL-000007', 23, 4, 1, 15000, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(5, 1, 499, 'IEL-000007', 23, 5, 2, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(6, 1, 499, 'IEL-000007', 23, 6, 2, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(7, 1, 499, 'IEL-000007', 23, 7, 2, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(8, 1, 499, 'IEL-000007', 23, 8, 2, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(9, 1, 499, 'IEL-000007', 23, 9, 2, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(10, 1, 499, 'IEL-000007', 23, 10, 2, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(11, 1, 499, 'IEL-000007', 23, 11, 2, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(12, 1, 499, 'IEL-000007', 23, 12, 2, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(13, 1, 499, 'IEL-000007', 23, 13, 2, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(14, 1, 499, 'IEL-000007', 23, 14, 2, 5000, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(15, 1, 499, 'IEL-000007', 23, 15, 2, 350, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(16, 1, 499, 'IEL-000007', 23, 16, 3, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(17, 1, 499, 'IEL-000007', 23, 17, 3, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(18, 1, 499, 'IEL-000007', 23, 18, 3, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(19, 1, 499, 'IEL-000007', 23, 19, 3, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(20, 1, 499, 'IEL-000007', 23, 20, 3, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(21, 1, 499, 'IEL-000007', 23, 21, 3, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(22, 1, 499, 'IEL-000007', 23, 22, 3, 550, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(23, 1, 499, 'IEL-000007', 23, 23, 3, 360, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(24, 1, 499, 'IEL-000007', 23, 24, 3, 0, 1, '2023-11-19 19:04:38', '2023-11-29 18:42:55'),
(25, 1, 499, 'IEL-000007', 23, 25, 1, 500, 1, '2023-11-19 19:56:25', '2023-11-29 18:42:55'),
(26, 0, 12, '42-1', 39, 1, 1, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(27, 0, 12, '42-1', 39, 2, 1, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(28, 0, 12, '42-1', 39, 3, 1, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(29, 0, 12, '42-1', 39, 4, 1, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(30, 0, 12, '42-1', 39, 25, 1, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(31, 0, 12, '42-1', 39, 5, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(32, 0, 12, '42-1', 39, 6, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(33, 0, 12, '42-1', 39, 7, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(34, 0, 12, '42-1', 39, 8, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(35, 0, 12, '42-1', 39, 9, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(36, 0, 12, '42-1', 39, 10, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(37, 0, 12, '42-1', 39, 11, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(38, 0, 12, '42-1', 39, 12, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(39, 0, 12, '42-1', 39, 13, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(40, 0, 12, '42-1', 39, 14, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(41, 0, 12, '42-1', 39, 15, 2, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(42, 0, 12, '42-1', 39, 16, 3, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(43, 0, 12, '42-1', 39, 17, 3, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(44, 0, 12, '42-1', 39, 18, 3, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(45, 0, 12, '42-1', 39, 19, 3, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(46, 0, 12, '42-1', 39, 20, 3, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(47, 0, 12, '42-1', 39, 21, 3, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(48, 0, 12, '42-1', 39, 22, 3, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(49, 0, 12, '42-1', 39, 23, 3, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39'),
(50, 0, 12, '42-1', 39, 24, 3, 0, 1, '2025-05-16 09:33:39', '2025-05-16 09:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `cylindars`
--

CREATE TABLE `cylindars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date DEFAULT NULL,
  `_receive_date` date DEFAULT NULL,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_cylidar_number` varchar(200) DEFAULT NULL,
  `_curum` varchar(200) DEFAULT NULL,
  `_length` varchar(200) DEFAULT NULL,
  `_purchase_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_order_date` varchar(255) DEFAULT NULL,
  `_order_by_customer` varchar(255) DEFAULT NULL,
  `_delivery_by_supplier` varchar(255) DEFAULT NULL,
  `_delivery_date` varchar(255) DEFAULT NULL,
  `_return_date` varchar(255) DEFAULT NULL,
  `_current_status` varchar(255) DEFAULT NULL,
  `_current_store` varchar(255) DEFAULT NULL,
  `_in_store_id` int(11) NOT NULL DEFAULT 0,
  `_out_store_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cylindar_location_histories`
--

CREATE TABLE `cylindar_location_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_date` date DEFAULT NULL,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_cylidar_number` varchar(255) DEFAULT NULL,
  `_curum` varchar(255) DEFAULT NULL,
  `_length` varchar(255) DEFAULT NULL,
  `_purchase_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_receive_date` date DEFAULT NULL,
  `_return_date` varchar(255) DEFAULT NULL,
  `_previous_store` varchar(255) DEFAULT NULL,
  `_current_store` varchar(255) DEFAULT NULL,
  `_in_store_id` int(11) NOT NULL DEFAULT 0,
  `_out_store_id` int(11) NOT NULL DEFAULT 0,
  `_current_status` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cylinder_product_price_lists`
--

CREATE TABLE `cylinder_product_price_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL DEFAULT 0,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_category_id` int(11) NOT NULL DEFAULT 0,
  `_brand_id` int(11) NOT NULL DEFAULT 0,
  `_pack_size_id` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` float NOT NULL DEFAULT 0,
  `_item` varchar(255) DEFAULT NULL,
  `_input_type` varchar(255) DEFAULT 'purchase',
  `_barcode` longtext DEFAULT NULL,
  `_model` varchar(255) DEFAULT NULL,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_qty` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_pur_rate` double NOT NULL DEFAULT 0,
  `_sales_discount` varchar(50) NOT NULL DEFAULT '0',
  `_sales_vat` varchar(50) NOT NULL DEFAULT '0',
  `_value` double NOT NULL DEFAULT 0,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `_p_discount_input` int(11) NOT NULL DEFAULT 0,
  `_p_discount_amount` int(11) NOT NULL DEFAULT 0,
  `_p_vat` int(11) NOT NULL DEFAULT 0,
  `_p_vat_amount` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_master_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `is_lebel_print` tinyint(4) NOT NULL DEFAULT 0,
  `_receive_type` int(11) NOT NULL DEFAULT 0,
  `_unique_barcode` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_order_number` varchar(150) DEFAULT NULL,
  `_table_name` varchar(255) DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_item_category` varchar(100) DEFAULT NULL,
  `_transfer_to_asset` tinyint(4) NOT NULL DEFAULT 0,
  `_short_note` varchar(255) DEFAULT NULL,
  `_customer_id` int(11) NOT NULL DEFAULT 0,
  `_supplier_id` int(11) NOT NULL DEFAULT 0,
  `_sales_invoice_date` date DEFAULT NULL,
  `_sales_details_id` int(11) NOT NULL DEFAULT 0,
  `_purchase_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_adjustments`
--

CREATE TABLE `damage_adjustments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` varchar(11) DEFAULT NULL,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_l_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damage_adjustments`
--

INSERT INTO `damage_adjustments` (`id`, `_order_number`, `_date`, `_time`, `_order_ref_id`, `_referance`, `_address`, `_phone`, `_ledger_id`, `_user_id`, `_user_name`, `_note`, `_sub_total`, `_discount_input`, `_total_discount`, `_total_vat`, `_total`, `_p_balance`, `_l_balance`, `organization_id`, `_branch_id`, `_store_id`, `_cost_center_id`, `_store_salves_id`, `_status`, `_lock`, `_created_by`, `_updated_by`, `created_at`, `updated_at`, `_budget_id`) VALUES
(1, '1', '2023-09-26', '10:52:50', NULL, NULL, 'null', 'null', 383, 46, 'Admin', 'Stock Used', 840.0000, 0.0000, 0.0000, 0.0000, 840.0000, 0.0000, 840.0000, 2, 2, 0, 2, NULL, 1, 0, '46-Admin', NULL, '2023-09-26 04:38:35', '2023-09-26 04:52:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `damage_adjustment_details`
--

CREATE TABLE `damage_adjustment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_barcodes`
--

CREATE TABLE `damage_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_form_settings`
--

CREATE TABLE `damage_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL,
  `_inline_discount` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL,
  `_show_vat` int(11) NOT NULL,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `_show_cost_rate` int(11) NOT NULL,
  `_show_expire_date` int(11) NOT NULL DEFAULT 0,
  `_show_manufacture_date` int(11) NOT NULL DEFAULT 0,
  `_show_warranty` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_is_header` tinyint(4) NOT NULL DEFAULT 0,
  `_is_footer` tinyint(4) NOT NULL DEFAULT 0,
  `_margin_top` varchar(30) DEFAULT NULL,
  `_margin_bottom` varchar(30) DEFAULT NULL,
  `_margin_left` varchar(30) DEFAULT NULL,
  `_margin_right` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damage_form_settings`
--

INSERT INTO `damage_form_settings` (`id`, `_default_inventory`, `_default_discount`, `_default_vat_account`, `_inline_discount`, `_show_barcode`, `_show_vat`, `_show_unit`, `_show_store`, `_show_self`, `_show_cost_rate`, `_show_expire_date`, `_show_manufacture_date`, `_show_warranty`, `created_at`, `updated_at`, `_is_header`, `_is_footer`, `_margin_top`, `_margin_bottom`, `_margin_left`, `_margin_right`) VALUES
(1, 7, 8, 2, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, '2022-06-04 17:56:56', '2023-09-20 03:55:20', 0, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `damage_from_stocks`
--

CREATE TABLE `damage_from_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `payment_date` date DEFAULT NULL,
  `_delivery_date` date DEFAULT NULL,
  `_time` varchar(60) NOT NULL,
  `_online_inv_no` varchar(255) DEFAULT NULL,
  `track_no` varchar(255) DEFAULT NULL,
  `driver_name` varchar(255) DEFAULT NULL,
  `driver_mob_no` varchar(255) DEFAULT NULL,
  `_mode_of_delivery` varchar(255) DEFAULT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_payment_terms` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` text DEFAULT NULL,
  `_delivery_details` text DEFAULT NULL,
  `_sub_total` double NOT NULL DEFAULT 0,
  `_discount_input` double NOT NULL DEFAULT 0,
  `_total_discount` double NOT NULL DEFAULT 0,
  `_total_vat` double NOT NULL DEFAULT 0,
  `_total` double NOT NULL DEFAULT 0,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `_trans_amount` double NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(60) DEFAULT NULL,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_from_stock_barcodes`
--

CREATE TABLE `damage_from_stock_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_no_id` int(11) NOT NULL DEFAULT 0,
  `_no_detail_id` int(11) NOT NULL DEFAULT 0,
  `_qty` int(11) NOT NULL DEFAULT 0,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_from_stock_details`
--

CREATE TABLE `damage_from_stock_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_showing_item_name` text DEFAULT NULL,
  `_short_note` varchar(255) DEFAULT NULL,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_is_free` tinyint(4) NOT NULL DEFAULT 0,
  `sale_qty` double NOT NULL DEFAULT 0,
  `free_qty` double NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_rate` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_discount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_vat` double NOT NULL DEFAULT 0,
  `_vat_amount` double NOT NULL DEFAULT 0,
  `_value` double NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) NOT NULL DEFAULT '1',
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_show_invoice` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_item_histories`
--

CREATE TABLE `damage_item_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_item` varchar(250) DEFAULT NULL,
  `_unique_barcode` int(11) NOT NULL DEFAULT 0,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `_barcode` longtext DEFAULT NULL,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_rate` double NOT NULL DEFAULT 0,
  `_pur_rate` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_p_discount_input` double NOT NULL DEFAULT 0,
  `_p_discount_amount` double NOT NULL DEFAULT 0,
  `_p_vat` double NOT NULL DEFAULT 0,
  `_p_vat_amount` double NOT NULL DEFAULT 0,
  `_sales_discount` double NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_value` double NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_master_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(70) DEFAULT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_input_type` varchar(30) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_time` time DEFAULT NULL,
  `_category_id` int(11) NOT NULL DEFAULT 0,
  `_item_name` varchar(255) DEFAULT NULL,
  `_cost_value` double NOT NULL DEFAULT 0,
  `_cost_rate` double NOT NULL DEFAULT 0,
  `_transection_ref` varchar(100) DEFAULT NULL,
  `_transection_detail_ref_id` varchar(150) DEFAULT NULL,
  `_transection` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_receive_accounts`
--

CREATE TABLE `damage_receive_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double NOT NULL DEFAULT 0,
  `_cr_amount` double NOT NULL DEFAULT 0,
  `_type` varchar(10) DEFAULT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_receive_barcodes`
--

CREATE TABLE `damage_receive_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_no_id` int(11) NOT NULL DEFAULT 0,
  `_no_detail_id` int(11) NOT NULL DEFAULT 0,
  `_qty` int(11) NOT NULL DEFAULT 0,
  `_barcode` varchar(255) NOT NULL,
  `_is_receive` int(11) NOT NULL DEFAULT 0,
  `_is_send` int(11) NOT NULL DEFAULT 0,
  `_is_stock` int(11) NOT NULL DEFAULT 0,
  `_is_full_damage` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_receive_details`
--

CREATE TABLE `damage_receive_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_barcode` longtext DEFAULT NULL,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_rate` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_discount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_vat` double NOT NULL DEFAULT 0,
  `_vat_amount` double NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_value` double NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_short_note` varchar(60) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_receive_form_settings`
--

CREATE TABLE `damage_receive_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL DEFAULT 0,
  `_default_purchase` int(11) NOT NULL DEFAULT 0,
  `_default_discount` int(11) NOT NULL DEFAULT 0,
  `_default_vat_account` int(11) NOT NULL DEFAULT 0,
  `_opening_inventory` int(11) NOT NULL DEFAULT 0,
  `_default_capital` int(11) NOT NULL DEFAULT 0,
  `_show_short_note` int(11) NOT NULL DEFAULT 0,
  `_show_unit` int(11) NOT NULL DEFAULT 0,
  `_show_barcode` int(11) NOT NULL DEFAULT 0,
  `_inline_discount` int(11) NOT NULL DEFAULT 0,
  `_show_vat` int(11) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL DEFAULT 0,
  `_show_self` int(11) NOT NULL DEFAULT 0,
  `_show_manufacture_date` int(11) NOT NULL DEFAULT 0,
  `_show_expire_date` int(11) NOT NULL DEFAULT 0,
  `_show_p_balance` int(11) NOT NULL DEFAULT 0,
  `_invoice_template` int(11) NOT NULL DEFAULT 0,
  `_is_header` int(11) NOT NULL DEFAULT 0,
  `_is_footer` int(11) NOT NULL DEFAULT 0,
  `_margin_top` varchar(255) NOT NULL DEFAULT '0',
  `_margin_bottom` varchar(255) DEFAULT NULL,
  `_margin_left` varchar(255) DEFAULT NULL,
  `_margin_right` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_receive_masters`
--

CREATE TABLE `damage_receive_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double NOT NULL DEFAULT 0,
  `_discount_input` double NOT NULL DEFAULT 0,
  `_total_discount` double NOT NULL DEFAULT 0,
  `_total_vat` double NOT NULL DEFAULT 0,
  `_total` double NOT NULL DEFAULT 0,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `_trans_amount` double NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_receive_type` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `_address` varchar(100) DEFAULT NULL,
  `_phone` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_damage_type` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_send_accounts`
--

CREATE TABLE `damage_send_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double NOT NULL DEFAULT 0,
  `_cr_amount` double NOT NULL DEFAULT 0,
  `_type` varchar(10) DEFAULT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_send_barcodes`
--

CREATE TABLE `damage_send_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_no_id` int(11) NOT NULL DEFAULT 0,
  `_no_detail_id` int(11) NOT NULL DEFAULT 0,
  `_qty` int(11) NOT NULL DEFAULT 0,
  `_barcode` varchar(255) NOT NULL,
  `_is_receive` int(11) NOT NULL DEFAULT 0,
  `_is_send` int(11) NOT NULL DEFAULT 0,
  `_is_stock` int(11) NOT NULL DEFAULT 0,
  `_is_full_damage` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_send_details`
--

CREATE TABLE `damage_send_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_barcode` longtext DEFAULT NULL,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_rate` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_discount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_vat` double NOT NULL DEFAULT 0,
  `_vat_amount` double NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_value` double NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_short_note` varchar(60) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_send_form_settings`
--

CREATE TABLE `damage_send_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL DEFAULT 0,
  `_default_purchase` int(11) NOT NULL DEFAULT 0,
  `_default_discount` int(11) NOT NULL DEFAULT 0,
  `_default_vat_account` int(11) NOT NULL DEFAULT 0,
  `_opening_inventory` int(11) NOT NULL DEFAULT 0,
  `_default_capital` int(11) NOT NULL DEFAULT 0,
  `_show_short_note` int(11) NOT NULL DEFAULT 0,
  `_show_unit` int(11) NOT NULL DEFAULT 0,
  `_show_barcode` int(11) NOT NULL DEFAULT 0,
  `_inline_discount` int(11) NOT NULL DEFAULT 0,
  `_show_vat` int(11) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL DEFAULT 0,
  `_show_self` int(11) NOT NULL DEFAULT 0,
  `_show_manufacture_date` int(11) NOT NULL DEFAULT 0,
  `_show_expire_date` int(11) NOT NULL DEFAULT 0,
  `_show_p_balance` int(11) NOT NULL DEFAULT 0,
  `_invoice_template` int(11) NOT NULL DEFAULT 0,
  `_is_header` int(11) NOT NULL DEFAULT 0,
  `_is_footer` int(11) NOT NULL DEFAULT 0,
  `_margin_top` varchar(255) NOT NULL DEFAULT '0',
  `_margin_bottom` varchar(255) DEFAULT NULL,
  `_margin_left` varchar(255) DEFAULT NULL,
  `_margin_right` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `damage_send_masters`
--

CREATE TABLE `damage_send_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double NOT NULL DEFAULT 0,
  `_discount_input` double NOT NULL DEFAULT 0,
  `_total_discount` double NOT NULL DEFAULT 0,
  `_total_vat` double NOT NULL DEFAULT 0,
  `_total` double NOT NULL DEFAULT 0,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `_trans_amount` double NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_receive_type` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `_address` varchar(100) DEFAULT NULL,
  `_phone` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `default_ledgers`
--

CREATE TABLE `default_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_sales` int(11) NOT NULL,
  `_sales_return` int(11) NOT NULL,
  `_purchase` int(11) NOT NULL,
  `_purchase_return` int(11) NOT NULL,
  `_sales_vat` int(11) NOT NULL,
  `_purchase_vat` int(11) NOT NULL,
  `_purchase_discount` int(11) NOT NULL,
  `_sales_discount` int(11) NOT NULL,
  `_inventory` int(11) NOT NULL,
  `_cost_of_sold` int(11) NOT NULL,
  `_steward_group` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `default_ledgers`
--

INSERT INTO `default_ledgers` (`id`, `_sales`, `_sales_return`, `_purchase`, `_purchase_return`, `_sales_vat`, `_purchase_vat`, `_purchase_discount`, `_sales_discount`, `_inventory`, `_cost_of_sold`, `_steward_group`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 56, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `_department` varchar(255) DEFAULT NULL,
  `_details` longtext DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_code` varchar(100) DEFAULT NULL,
  `_details` text DEFAULT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `order` decimal(15,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`id`, `_name`, `_status`, `_user`, `created_at`, `updated_at`, `_code`, `_details`, `is_delete`, `status`, `order`) VALUES
(1, 'Teacher', 1, 0, NULL, NULL, NULL, NULL, 0, 0, '0.0000');

-- --------------------------------------------------------

--
-- Table structure for table `direct_manufature_row_goods`
--

CREATE TABLE `direct_manufature_row_goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `_conversion_qty` decimal(10,0) NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_rate` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_discount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_vat` double NOT NULL DEFAULT 0,
  `_vat_amount` double NOT NULL DEFAULT 0,
  `_value` double NOT NULL DEFAULT 0,
  `_warranty` varchar(255) NOT NULL DEFAULT '0',
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_kitchen_item` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `direct_productions`
--

CREATE TABLE `direct_productions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(120) DEFAULT NULL,
  `_date` date NOT NULL,
  `_start_date` date DEFAULT NULL,
  `_end_date` date DEFAULT NULL,
  `_reference` varchar(255) DEFAULT NULL,
  `_quatation_no` varchar(255) DEFAULT NULL,
  `_sales_order_no` varchar(255) DEFAULT NULL,
  `_pm_id` int(11) NOT NULL DEFAULT 0,
  `_apporoved_by_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_note` varchar(255) DEFAULT NULL,
  `_type` varchar(255) DEFAULT NULL,
  `_p_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `_total_amount` double NOT NULL DEFAULT 0,
  `_total_saleable_amount` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_created_by` int(11) NOT NULL DEFAULT 0,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `direct_production_barcodes`
--

CREATE TABLE `direct_production_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_no_id` int(11) NOT NULL DEFAULT 0,
  `_no_detail_id` int(11) NOT NULL DEFAULT 0,
  `_qty` int(11) NOT NULL DEFAULT 0,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `direct_production_finis_goods`
--

CREATE TABLE `direct_production_finis_goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `production_partial_receives_id` int(11) NOT NULL DEFAULT 0,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_short_note` varchar(255) DEFAULT NULL,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_rate` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_discount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_vat` double NOT NULL DEFAULT 0,
  `_vat_amount` double NOT NULL DEFAULT 0,
  `_value` double NOT NULL DEFAULT 0,
  `_warranty` varchar(255) NOT NULL DEFAULT '0',
  `_barcode` longtext DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `bn_name` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `bn_name` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_stage` int(11) NOT NULL DEFAULT 0,
  `document_title` varchar(255) DEFAULT NULL,
  `_poul_no` varchar(200) DEFAULT NULL,
  `_documents` varchar(255) DEFAULT NULL,
  `_details` longtext DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` int(11) NOT NULL,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_duties`
--

CREATE TABLE `employee_duties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `entry_type` varchar(50) DEFAULT NULL,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_date` date DEFAULT NULL,
  `_time` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `road` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `latitude` varchar(200) DEFAULT NULL,
  `longitude` varchar(200) DEFAULT NULL,
  `borough` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `full_address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `free_item_setups`
--

CREATE TABLE `free_item_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_free_item_id` int(11) NOT NULL DEFAULT 0,
  `_free_qty_slot_min` double NOT NULL DEFAULT 0,
  `_free_qty_slot_max` double NOT NULL DEFAULT 0,
  `_free_qty` double NOT NULL DEFAULT 0,
  `_free_sales_rate` double NOT NULL DEFAULT 0,
  `_free_unit_id` double NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_transection_unit` double NOT NULL DEFAULT 0,
  `_base_unit` double NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_allow_all_branch` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `_bin` varchar(50) DEFAULT NULL,
  `_tin` varchar(50) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `bg_image` varchar(255) DEFAULT NULL,
  `footerContent` longtext DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_phone` varchar(120) DEFAULT NULL,
  `_email` varchar(120) DEFAULT NULL,
  `_sales_note` text DEFAULT NULL,
  `_sales_return__note` text DEFAULT NULL,
  `_purchse_note` text DEFAULT NULL,
  `_purchase_return_note` text DEFAULT NULL,
  `_top_title` varchar(255) DEFAULT NULL,
  `_ac_type` tinyint(4) NOT NULL DEFAULT 0,
  `_sms_service` tinyint(4) NOT NULL DEFAULT 0,
  `_barcode_service` tinyint(4) NOT NULL DEFAULT 0,
  `_bank_group` int(11) NOT NULL DEFAULT 0,
  `_cash_group` int(11) NOT NULL DEFAULT 0,
  `_auto_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_pur_base_model_barcode` tinyint(4) NOT NULL DEFAULT 0,
  `_opening_ledger` int(11) NOT NULL DEFAULT 0,
  `_employee_group` int(11) NOT NULL DEFAULT 0,
  `small_logo` varchar(255) DEFAULT NULL,
  `_water_mark_image` varchar(255) DEFAULT NULL,
  `_direct_inc_exp_heads` varchar(200) DEFAULT NULL,
  `_indirect_inc_exp_heads` varchar(200) DEFAULT NULL,
  `_customer_incentive_ledger` varchar(100) DEFAULT NULL,
  `_baddebt_ledgers` varchar(100) DEFAULT NULL,
  `_honorarium_ledger` varchar(50) DEFAULT NULL,
  `_sales_phones` text DEFAULT NULL,
  `_order_phones` varchar(255) DEFAULT NULL,
  `sms_apikey` varchar(200) DEFAULT NULL,
  `sms_secretkey` varchar(200) DEFAULT NULL,
  `sms_sender` varchar(200) DEFAULT NULL,
  `sms_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `title`, `name`, `_address`, `keywords`, `author`, `url`, `_bin`, `_tin`, `logo`, `bg_image`, `footerContent`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`, `_phone`, `_email`, `_sales_note`, `_sales_return__note`, `_purchse_note`, `_purchase_return_note`, `_top_title`, `_ac_type`, `_sms_service`, `_barcode_service`, `_bank_group`, `_cash_group`, `_auto_lock`, `_pur_base_model_barcode`, `_opening_ledger`, `_employee_group`, `small_logo`, `_water_mark_image`, `_direct_inc_exp_heads`, `_indirect_inc_exp_heads`, `_customer_incentive_ledger`, `_baddebt_ledgers`, `_honorarium_ledger`, `_sales_phones`, `_order_phones`, `sms_apikey`, `sms_secretkey`, `sms_sender`, `sms_url`) VALUES
(1, 'SAIF POWER GROUP', 'TARAFDER MODEL MADRASAH', 'Abdur Rahim Tarafder Road,Fathepur Sadar\r\nJashore.', '', 'TARAFDER MODEL MADRASAH', '', '', '16038', 'images/05132025011044682247b455257.webp', 'images/05152025125652682590349ae0e.png', NULL, NULL, NULL, NULL, '2021-06-06 08:00:54', '2025-05-15 06:56:52', 'Mob:01753032219', 'info@tmmadrasah.com', 'Goods sold are not returnable. If need any support, Call:', '', '', '', '﷽', 0, 0, 0, 3, 4, 0, 1, 0, 42, 'images/05132025011044682247b4554d1.webp', 'images/05132025011044682247b45568b.webp', '10,15,20', '15', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `honorarium_bills`
--

CREATE TABLE `honorarium_bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_month` int(11) NOT NULL DEFAULT 0,
  `_year` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `voucher_id` int(11) NOT NULL DEFAULT 0,
  `voucher_code` varchar(255) DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_amount` decimal(10,0) NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `approve_by_1` int(11) NOT NULL DEFAULT 0,
  `approve_by_2` int(11) NOT NULL DEFAULT 0,
  `approve_by_3` int(11) NOT NULL DEFAULT 0,
  `approve_by_4` int(11) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(100) DEFAULT NULL,
  `_updated_by` varchar(100) DEFAULT NULL,
  `_is_posting` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `honorarium_bill_details`
--

CREATE TABLE `honorarium_bill_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_month` int(11) NOT NULL DEFAULT 0,
  `_year` int(11) NOT NULL DEFAULT 0,
  `_account_type_id` int(11) NOT NULL DEFAULT 0,
  `_account_group_id` int(11) NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_amount` double NOT NULL DEFAULT 0,
  `_paid_amount` double NOT NULL DEFAULT 0,
  `_due_amount` double NOT NULL DEFAULT 0,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `honorarium_payments`
--

CREATE TABLE `honorarium_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_month` int(11) NOT NULL DEFAULT 0,
  `_year` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_honorarium_ledger_id` int(11) NOT NULL DEFAULT 0,
  `voucher_id` int(11) NOT NULL DEFAULT 0,
  `voucher_code` varchar(255) DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_amount` decimal(10,0) NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `approve_by_1` int(11) NOT NULL DEFAULT 0,
  `approve_by_2` int(11) NOT NULL DEFAULT 0,
  `approve_by_3` int(11) NOT NULL DEFAULT 0,
  `approve_by_4` int(11) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_is_posting` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(100) DEFAULT NULL,
  `_updated_by` varchar(100) DEFAULT NULL,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `honorarium_payment_details`
--

CREATE TABLE `honorarium_payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_month` int(11) NOT NULL DEFAULT 0,
  `_year` int(11) NOT NULL DEFAULT 0,
  `_account_type_id` int(11) NOT NULL DEFAULT 0,
  `_account_group_id` int(11) NOT NULL DEFAULT 0,
  `_bill_master_id` int(11) NOT NULL DEFAULT 0,
  `_bill_detail_id` int(11) NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_amount` double NOT NULL DEFAULT 0,
  `_previous_receive` double NOT NULL DEFAULT 0,
  `_due_amount` double NOT NULL DEFAULT 0,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_is_effect` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `honorim_setups`
--

CREATE TABLE `honorim_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_amount` double NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_attendances`
--

CREATE TABLE `hrm_attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` int(11) NOT NULL DEFAULT 1,
  `_cost_center_id` int(11) NOT NULL DEFAULT 1,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_number` varchar(100) DEFAULT NULL,
  `_type` int(11) NOT NULL DEFAULT 0,
  `_datetime` datetime DEFAULT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_emp_id` varchar(200) DEFAULT NULL,
  `_employee` int(11) NOT NULL DEFAULT 0,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `reg_id` varchar(100) DEFAULT NULL,
  `_shift` varchar(30) DEFAULT NULL,
  `atdstat` varchar(10) DEFAULT NULL,
  `flag` varchar(100) DEFAULT NULL,
  `manual_remark` varchar(150) DEFAULT NULL,
  `timediff` varchar(50) DEFAULT NULL,
  `in_time` time DEFAULT NULL,
  `out_time` time DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_attendances`
--

INSERT INTO `hrm_attendances` (`id`, `organization_id`, `_branch_id`, `_cost_center_id`, `_employee_id`, `_number`, `_type`, `_datetime`, `_user_id`, `_is_delete`, `created_at`, `updated_at`, `_emp_id`, `_employee`, `_updated_by`, `reg_id`, `_shift`, `atdstat`, `flag`, `manual_remark`, `timediff`, `in_time`, `out_time`, `remarks`) VALUES
(1, 1, 1, 1, 4, 'ATD-20240626-4', 0, '2024-06-26 10:24:47', 2, 0, '2025-08-03 08:46:25', '2025-08-03 08:46:25', '', 0, 2, '', NULL, 'P', '0', NULL, '00:28:42', '10:24:47', '10:53:29', 'Auto migrated from SQL Server'),
(2, 1, 1, 1, 511, 'ATD-20240626-511', 0, '2024-06-26 10:28:07', 2, 0, '2025-08-03 08:46:25', '2025-08-03 08:46:25', 'SIEL-000005', 0, 2, 'SIEL-000005', NULL, 'P', '0', NULL, '02:10:19', '10:28:07', '12:38:26', 'Auto migrated from SQL Server'),
(3, 1, 1, 1, 4, 'ATD-20250803-4', 0, '2025-08-03 12:05:51', 2, 0, '2025-08-03 08:47:47', '2025-08-03 08:51:05', '', 0, 2, '', NULL, 'P', '0', NULL, '02:43:27', '12:05:51', '14:49:18', 'Auto migrated from SQL Server'),
(4, 1, 1, 1, 512, 'ATD-20250803-512', 0, '2025-08-03 12:05:57', 2, 0, '2025-08-03 08:51:05', '2025-08-03 08:51:05', 'SIEL-000002', 0, 2, 'SIEL-000002', NULL, 'P', '0', NULL, '02:43:23', '12:05:57', '14:49:20', 'Auto migrated from SQL Server');

-- --------------------------------------------------------

--
-- Table structure for table `hrm_departments`
--

CREATE TABLE `hrm_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_department` varchar(255) DEFAULT NULL,
  `_details` longtext DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_departments`
--

INSERT INTO `hrm_departments` (`id`, `_department`, `_details`, `_status`, `_user`, `created_at`, `updated_at`) VALUES
(1, 'Madrsha', NULL, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hrm_education`
--

CREATE TABLE `hrm_education` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_level` varchar(255) NOT NULL,
  `_subject` varchar(255) NOT NULL,
  `_institute` varchar(255) NOT NULL,
  `_year` varchar(255) DEFAULT NULL,
  `_score` varchar(255) DEFAULT NULL,
  `_edsdate` date DEFAULT NULL,
  `_ededate` date DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `_employee_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_emergencies`
--

CREATE TABLE `hrm_emergencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_relationship` varchar(255) DEFAULT NULL,
  `_mobile` varchar(255) DEFAULT NULL,
  `_home` varchar(255) DEFAULT NULL,
  `_work` varchar(255) DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `_employee_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_empaddresses`
--

CREATE TABLE `hrm_empaddresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_type` varchar(255) DEFAULT NULL COMMENT 'present and parmanet address',
  `_address` varchar(255) DEFAULT NULL,
  `_post` varchar(255) DEFAULT NULL,
  `_police` varchar(255) DEFAULT NULL COMMENT 'Thana',
  `_district` varchar(255) DEFAULT NULL,
  `_eaddress` varchar(255) DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `_employee_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_employees`
--

CREATE TABLE `hrm_employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_code` varchar(255) DEFAULT NULL COMMENT 'Manual Code or Auto generated code department Wise',
  `_photo` varchar(255) DEFAULT NULL,
  `_signature` varchar(255) DEFAULT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_father` varchar(255) DEFAULT NULL,
  `_mother` varchar(255) DEFAULT NULL,
  `_spouse` varchar(255) DEFAULT NULL,
  `_mobile1` varchar(255) DEFAULT NULL,
  `_mobile2` varchar(255) DEFAULT NULL,
  `_spousesmobile` varchar(255) DEFAULT NULL,
  `_nid` varchar(255) DEFAULT NULL,
  `_gender` varchar(255) DEFAULT NULL,
  `_bloodgroup` varchar(255) DEFAULT NULL,
  `_religion` varchar(255) DEFAULT NULL,
  `_dob` varchar(255) DEFAULT NULL,
  `_education` varchar(255) DEFAULT NULL,
  `_email` varchar(255) DEFAULT NULL,
  `_jobtitle_id` int(11) NOT NULL DEFAULT 0,
  `_department_id` int(11) NOT NULL DEFAULT 0,
  `_category_id` int(11) NOT NULL DEFAULT 0,
  `_grade_id` int(11) NOT NULL DEFAULT 0,
  `_location` varchar(255) DEFAULT NULL,
  `_officedes` varchar(255) DEFAULT NULL,
  `_bank` varchar(255) DEFAULT NULL,
  `_bankac` varchar(255) DEFAULT NULL,
  `_tradeing_id` int(11) NOT NULL DEFAULT 0,
  `_project_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_profitcenter_id` int(11) NOT NULL DEFAULT 0,
  `_active` int(11) NOT NULL DEFAULT 1,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `_doj` date DEFAULT NULL,
  `_tin` varchar(255) DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_created_by` varchar(120) DEFAULT NULL,
  `_updated_by` varchar(120) DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `_zone_id` int(11) NOT NULL DEFAULT 0,
  `_gross_salary` float(15,4) NOT NULL DEFAULT 0.0000,
  `payment_type` varchar(50) DEFAULT NULL,
  `basic_salary` double(15,4) NOT NULL DEFAULT 0.0000,
  `net_salary` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `allowances` double(15,4) NOT NULL DEFAULT 0.0000,
  `deductions` double(15,4) NOT NULL DEFAULT 0.0000,
  `_bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_employees`
--

INSERT INTO `hrm_employees` (`id`, `_code`, `_photo`, `_signature`, `_name`, `_father`, `_mother`, `_spouse`, `_mobile1`, `_mobile2`, `_spousesmobile`, `_nid`, `_gender`, `_bloodgroup`, `_religion`, `_dob`, `_education`, `_email`, `_jobtitle_id`, `_department_id`, `_category_id`, `_grade_id`, `_location`, `_officedes`, `_bank`, `_bankac`, `_tradeing_id`, `_project_id`, `_cost_center_id`, `_branch_id`, `organization_id`, `_profitcenter_id`, `_active`, `_status`, `_doj`, `_tin`, `_user`, `_ledger_id`, `user_id`, `created_at`, `updated_at`, `_created_by`, `_updated_by`, `doj`, `_zone_id`, `_gross_salary`, `payment_type`, `basic_salary`, `net_salary`, `allowances`, `deductions`, `_bio`) VALUES
(1, '42-12', NULL, NULL, 'Md. Sabbir Hossain', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 50, 0, '2025-05-13 04:57:51', '2025-05-13 04:57:51', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(2, '42-11', NULL, NULL, 'Jannati Begum', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 49, 0, '2025-05-13 04:57:52', '2025-05-13 04:57:52', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(3, '42-10', NULL, NULL, 'Firoza Begum', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 48, 0, '2025-05-13 04:57:52', '2025-05-13 04:57:52', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(4, '42-9', NULL, NULL, 'Md. Nahid Hasan', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 47, 0, '2025-05-13 04:57:53', '2025-05-13 04:57:53', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(5, '42-8', NULL, NULL, 'Md. Abu Shihab', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 46, 0, '2025-05-13 04:57:54', '2025-05-13 04:57:54', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(6, '42-7', NULL, NULL, 'Rehena Begum', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 45, 0, '2025-05-13 04:57:55', '2025-05-13 04:57:55', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(7, '42-6', NULL, NULL, 'Hafiz Mowlana MD Robiul', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 44, 0, '2025-05-13 04:57:57', '2025-05-13 04:57:57', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(8, '42-5', NULL, NULL, 'Mowlana Zahidul Islam', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 43, 0, '2025-05-13 04:57:57', '2025-05-13 04:57:57', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(9, '42-4', NULL, NULL, 'Hafiz Naim Hossain', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 42, 0, '2025-05-13 04:57:58', '2025-05-13 04:57:58', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(10, '42-3', NULL, NULL, 'Mowlana Shoriful islam', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 41, 0, '2025-05-13 04:57:59', '2025-05-13 04:57:59', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(11, '42-2', NULL, NULL, 'Mowlana Ruhul Quddush', NULL, NULL, NULL, '', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, 0, 1, 0, 0, 1, 1, NULL, NULL, 46, 40, 0, '2025-05-13 04:57:59', '2025-05-13 04:57:59', '46-', NULL, NULL, 0, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL),
(12, '42-1', NULL, NULL, 'Mowlana Abu Sufian(Assistant Principle)', '', '', '', '', '', '', '', '', '', '', '', '', '', 1, 1, 1, 8, '24', '1', '1', '1', 0, 0, 1, 1, 1, 0, 1, 1, '0000-00-00', '', 46, 39, 0, '2025-05-13 04:58:00', '2025-05-16 09:33:39', '46-', NULL, NULL, 3, 0.0000, NULL, 0.0000, '0.0000', 0.0000, 0.0000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hrm_emp_categories`
--

CREATE TABLE `hrm_emp_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_emp_categories`
--

INSERT INTO `hrm_emp_categories` (`id`, `_name`, `_status`, `_user`, `created_at`, `updated_at`) VALUES
(1, 'Management', 1, 46, NULL, '2023-10-10 06:29:04'),
(2, 'Non Management', 1, 0, NULL, NULL),
(3, 'Temporary', 1, 0, NULL, NULL),
(4, 'Non Management-CCTO', 1, 0, NULL, NULL),
(5, 'Management-CCTO', 1, 0, NULL, NULL),
(6, 'Casual', 1, 0, NULL, NULL),
(7, 'Foreign Employee', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hrm_emp_locations`
--

CREATE TABLE `hrm_emp_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_user` varchar(100) DEFAULT NULL,
  `_code` varchar(50) DEFAULT NULL,
  `_description` text DEFAULT NULL,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_emp_locations`
--

INSERT INTO `hrm_emp_locations` (`id`, `_name`, `_status`, `created_at`, `updated_at`, `_user`, `_code`, `_description`, `_is_delete`) VALUES
(1, 'Pacific Centre', 1, NULL, NULL, NULL, NULL, NULL, 0),
(2, 'Khawja Tower', 1, NULL, NULL, NULL, NULL, NULL, 0),
(3, 'Mongla', 1, NULL, NULL, NULL, NULL, NULL, 0),
(4, 'Chittagong', 1, NULL, NULL, NULL, NULL, NULL, 0),
(5, 'Mymensingh', 1, NULL, NULL, NULL, NULL, NULL, 0),
(6, 'Bhasanchor', 1, NULL, NULL, NULL, NULL, NULL, 0),
(7, 'Rangpur', 1, NULL, NULL, NULL, NULL, NULL, 0),
(8, 'Payra', 1, NULL, NULL, NULL, NULL, NULL, 0),
(9, 'Patenga', 1, NULL, NULL, NULL, NULL, NULL, 0),
(10, 'Netrokona', 1, NULL, NULL, NULL, NULL, NULL, 0),
(11, 'Agrabad', 1, NULL, NULL, NULL, NULL, NULL, 0),
(12, 'Blank', 1, NULL, NULL, NULL, NULL, NULL, 0),
(13, 'CTG', 1, NULL, NULL, NULL, NULL, NULL, 0),
(14, 'Pubail', 1, NULL, NULL, NULL, NULL, NULL, 0),
(15, 'CTG-Port', 1, NULL, NULL, NULL, NULL, NULL, 0),
(16, 'Rupayon Centre', 1, NULL, NULL, NULL, NULL, NULL, 0),
(17, 'Tumoliya-Kaligonj', 1, NULL, NULL, NULL, NULL, NULL, 0),
(18, 'MD House', 1, NULL, NULL, NULL, NULL, NULL, 0),
(19, 'Kamalapur', 1, NULL, NULL, NULL, NULL, NULL, 0),
(20, 'Pangao', 1, NULL, NULL, NULL, NULL, NULL, 0),
(21, 'Narayanganj', 1, NULL, NULL, NULL, NULL, NULL, 0),
(22, 'Sylhet', 1, NULL, NULL, NULL, NULL, NULL, 0),
(23, 'Gazipur', 1, NULL, NULL, NULL, NULL, NULL, 0),
(24, 'Jashore', 1, NULL, NULL, NULL, NULL, NULL, 0),
(25, 'Mymensingh-RE', 1, NULL, NULL, NULL, NULL, NULL, 0),
(26, 'Pubail Warehouse', 1, NULL, NULL, NULL, NULL, NULL, 0),
(27, 'Purbachol-workshop', 1, NULL, NULL, NULL, NULL, NULL, 0),
(28, 'Dinajpur', 1, NULL, NULL, NULL, NULL, NULL, 0),
(29, 'Bogura', 1, NULL, NULL, NULL, NULL, NULL, 0),
(30, 'Khulna', 1, NULL, NULL, NULL, NULL, NULL, 0),
(31, 'Valuka', 1, NULL, NULL, NULL, NULL, NULL, 0),
(32, 'Narsingdi', 1, NULL, NULL, NULL, NULL, NULL, 0),
(33, 'Cox\'s Bazar', 1, NULL, NULL, NULL, NULL, NULL, 0),
(34, 'Comilla', 1, NULL, NULL, NULL, NULL, NULL, 0),
(35, 'Faridpur', 1, NULL, NULL, NULL, NULL, NULL, 0),
(36, 'Potiya-Chittagong', 1, NULL, NULL, NULL, NULL, NULL, 0),
(37, 'Rangunia-Chittagong', 1, NULL, NULL, NULL, NULL, NULL, 0),
(38, 'Motlab Dakhin-Chadpur', 1, NULL, NULL, NULL, NULL, NULL, 0),
(39, 'Shibpur-Narsindi', 1, NULL, NULL, NULL, NULL, NULL, 0),
(40, 'Rajor-Madaripur', 1, NULL, NULL, NULL, NULL, NULL, 0),
(41, 'Sadarpur-Faridpur', 1, NULL, NULL, NULL, NULL, NULL, 0),
(42, 'Kalia-Narail', 1, NULL, NULL, NULL, NULL, NULL, 0),
(43, 'Trishal-Mymensingh', 1, NULL, NULL, NULL, NULL, NULL, 0),
(44, 'Atpara-Netrokona', 1, NULL, NULL, NULL, NULL, NULL, 0),
(45, 'Kendua-Netrokona', 1, NULL, NULL, NULL, NULL, NULL, 0),
(46, 'Purbadhala-Netrokona', 1, NULL, NULL, NULL, NULL, NULL, 0),
(47, 'Bagha-Rajshahi', 1, NULL, NULL, NULL, NULL, NULL, 0),
(48, 'Bogra-Bogra', 1, NULL, NULL, NULL, NULL, NULL, 0),
(49, 'Dhunut-Bogra', 1, NULL, NULL, NULL, NULL, NULL, 0),
(50, 'Nondigram-Bogra', 1, NULL, NULL, NULL, NULL, NULL, 0),
(51, 'Nawga-Nawga', 1, NULL, NULL, NULL, NULL, NULL, 0),
(52, 'Domar-Nilfamari', 1, NULL, NULL, NULL, NULL, NULL, 0),
(53, 'Belkuchi-Serajgonj', 1, NULL, NULL, NULL, NULL, NULL, 0),
(54, 'Paba-Rajshahi', 1, NULL, NULL, NULL, NULL, NULL, 0),
(55, 'Savar', 1, NULL, NULL, NULL, NULL, NULL, 0),
(56, 'KICD Cleaner', 1, NULL, NULL, NULL, NULL, NULL, 0),
(57, 'Tumulia-Kaliganj', 1, NULL, NULL, NULL, NULL, NULL, 0),
(58, 'Tumoliya-SPPL', 1, NULL, NULL, NULL, NULL, NULL, 0),
(59, 'Mirpur DOHS', 1, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `hrm_experiences`
--

CREATE TABLE `hrm_experiences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_company` varchar(255) DEFAULT NULL,
  `_jobtitle_id` int(11) NOT NULL DEFAULT 0,
  `_wfrom` date DEFAULT NULL,
  `_wto` date DEFAULT NULL,
  `_note` text DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `_employee_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_grades`
--

CREATE TABLE `hrm_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_grade` varchar(255) DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_grades`
--

INSERT INTO `hrm_grades` (`id`, `_grade`, `_user`, `_status`, `created_at`, `updated_at`) VALUES
(1, 'Grade-07', 0, 1, NULL, NULL),
(2, 'Grade-03', 0, 1, NULL, NULL),
(3, 'Grade-02', 0, 1, NULL, NULL),
(4, 'Grade-01', 0, 1, NULL, NULL),
(5, 'Grade-17', 0, 1, NULL, NULL),
(6, 'Grade-13', 0, 1, NULL, NULL),
(7, 'Grade-10', 0, 1, NULL, NULL),
(8, 'Grade-08', 0, 1, NULL, NULL),
(9, 'Grade-06', 0, 1, NULL, NULL),
(10, 'Grade-12', 0, 1, NULL, NULL),
(11, 'Grade-14', 0, 1, NULL, NULL),
(12, 'Grade-04', 0, 1, NULL, NULL),
(13, 'Grade-05', 0, 1, NULL, NULL),
(14, 'Grade-18', 0, 1, NULL, NULL),
(15, 'Grade-09', 0, 1, NULL, NULL),
(16, 'Grade-11', 0, 1, NULL, NULL),
(17, 'Grade-16', 0, 1, NULL, NULL),
(18, 'Grade-15', 0, 1, NULL, NULL),
(19, 'Grade-19', 0, 1, NULL, NULL),
(20, 'Grade-20', 0, 1, NULL, NULL),
(21, 'Grade-17S', 0, 1, NULL, NULL),
(22, 'Grade-16s', 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hrm_guarantors`
--

CREATE TABLE `hrm_guarantors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_father` varchar(255) DEFAULT NULL,
  `_mother` varchar(255) DEFAULT NULL,
  `_occupation` varchar(255) DEFAULT NULL,
  `_workstation` varchar(255) DEFAULT NULL,
  `_address1` varchar(255) DEFAULT NULL,
  `_address2` varchar(255) DEFAULT NULL,
  `_mobile` varchar(255) DEFAULT NULL,
  `_email` varchar(255) DEFAULT NULL,
  `_nationalid` varchar(255) DEFAULT NULL,
  `_photo` varchar(255) DEFAULT NULL,
  `_dob` varchar(255) DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `_employee_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_holidays`
--

CREATE TABLE `hrm_holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_dfrom` date DEFAULT NULL,
  `_dto` date DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_holiday_details`
--

CREATE TABLE `hrm_holiday_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_type` varchar(255) DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_holidaysid` int(11) NOT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_itaxconfigs`
--

CREATE TABLE `hrm_itaxconfigs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_maxinvestment` double(15,4) NOT NULL DEFAULT 0.0000,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_itaxledgers`
--

CREATE TABLE `hrm_itaxledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_ledger` int(11) NOT NULL DEFAULT 0,
  `_exlimit` double(15,4) NOT NULL DEFAULT 0.0000,
  `_ledgerno` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_itaxpayables`
--

CREATE TABLE `hrm_itaxpayables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_plevel` varchar(255) DEFAULT NULL,
  `_plimit` double(15,4) NOT NULL DEFAULT 0.0000,
  `_ppercent` double(15,4) NOT NULL DEFAULT 0.0000,
  `_payableno` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_itaxrebates`
--

CREATE TABLE `hrm_itaxrebates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_rlevel` varchar(255) DEFAULT NULL,
  `_rlimit` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rpercent` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rebateno` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_jobcontracts`
--

CREATE TABLE `hrm_jobcontracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_ctype` varchar(255) DEFAULT NULL,
  `_csdate` date DEFAULT NULL,
  `_cedate` date DEFAULT NULL,
  `_cdetail` longtext DEFAULT NULL,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_jobcontracts`
--

INSERT INTO `hrm_jobcontracts` (`id`, `_ctype`, `_csdate`, `_cedate`, `_cdetail`, `_employee_id`, `_user`, `created_at`, `updated_at`, `_status`) VALUES
(1, '', '0000-00-00', '0000-00-00', '', 12, 46, '2025-05-16 09:33:39', '2025-05-16 09:33:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hrm_jobs`
--

CREATE TABLE `hrm_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_jobtitle_id` int(11) NOT NULL DEFAULT 0,
  `_job_id` int(11) NOT NULL DEFAULT 0,
  `_specification` text DEFAULT NULL,
  `_jtype` varchar(255) DEFAULT NULL,
  `_status` varchar(255) DEFAULT NULL,
  `_location` varchar(255) DEFAULT NULL,
  `_responsibility` varchar(255) DEFAULT NULL,
  `_joindate` date DEFAULT NULL,
  `_salary` double(15,4) NOT NULL DEFAULT 0.0000,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_jobtitles`
--

CREATE TABLE `hrm_jobtitles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_title` varchar(255) DEFAULT NULL,
  `_specification` longtext DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_languages`
--

CREATE TABLE `hrm_languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_language` varchar(255) DEFAULT NULL,
  `_fluency` varchar(255) DEFAULT NULL,
  `_competency` varchar(255) DEFAULT NULL,
  `_lnote` longtext DEFAULT NULL,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_leavebalances`
--

CREATE TABLE `hrm_leavebalances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_ltype` varchar(255) DEFAULT NULL,
  `_lday` double(15,4) NOT NULL DEFAULT 0.0000,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_leaveentitlements`
--

CREATE TABLE `hrm_leaveentitlements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_ltype` int(11) NOT NULL DEFAULT 0,
  `_lday` double(15,4) NOT NULL DEFAULT 0.0000,
  `_period` int(11) NOT NULL DEFAULT 0,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_leavetypes`
--

CREATE TABLE `hrm_leavetypes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_type` varchar(255) DEFAULT NULL,
  `_number_of_days` double(15,2) NOT NULL DEFAULT 0.00,
  `_user` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_leavetypes`
--

INSERT INTO `hrm_leavetypes` (`id`, `_type`, `_number_of_days`, `_user`, `_status`, `created_at`, `updated_at`) VALUES
(2, 'Casual Leave', 10.00, 46, 1, '2023-07-04 18:18:57', '2023-07-05 04:12:25'),
(3, 'Payable', 0.00, 46, 1, '2023-07-04 18:19:10', '2023-07-05 06:17:07'),
(4, 'Sick Leave', 14.00, 46, 1, '2023-07-04 18:19:24', '2023-07-05 04:12:32');

-- --------------------------------------------------------

--
-- Table structure for table `hrm_monthly_salary_details`
--

CREATE TABLE `hrm_monthly_salary_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_master_id` int(11) NOT NULL,
  `_employee_id` int(11) NOT NULL,
  `_employee_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_payhead_id` int(11) NOT NULL,
  `_payhead_type_id` int(11) NOT NULL DEFAULT 1,
  `_amount` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_emp_code` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_monthly_salary_masters`
--

CREATE TABLE `hrm_monthly_salary_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_employee_id` int(11) NOT NULL,
  `_employee_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_emp_code` varchar(255) DEFAULT NULL,
  `_month` int(11) NOT NULL,
  `_year` int(11) NOT NULL,
  `_paydays` int(11) NOT NULL DEFAULT 0,
  `_present_days` int(11) NOT NULL DEFAULT 0,
  `_absent_days` int(11) NOT NULL DEFAULT 0,
  `_arrdays` int(11) NOT NULL DEFAULT 0,
  `_verify` int(11) NOT NULL DEFAULT 0,
  `total_earnings` double NOT NULL DEFAULT 0,
  `total_deduction` double NOT NULL DEFAULT 0,
  `net_total_earning` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_payment_type` int(11) NOT NULL DEFAULT 0,
  `_jobtitle_id` int(11) NOT NULL DEFAULT 0,
  `_department_id` int(11) NOT NULL DEFAULT 0,
  `_category_id` int(11) NOT NULL DEFAULT 0,
  `_grade_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_nominees`
--

CREATE TABLE `hrm_nominees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_nname` varchar(255) DEFAULT NULL,
  `_nfather` varchar(255) DEFAULT NULL,
  `_nmother` varchar(255) DEFAULT NULL,
  `_ndob` date DEFAULT NULL,
  `_nnationalid` varchar(255) DEFAULT NULL,
  `_nmobile` varchar(255) DEFAULT NULL,
  `_naddress1` varchar(255) DEFAULT NULL,
  `_naddress2` varchar(255) DEFAULT NULL,
  `_nrelation` varchar(255) DEFAULT NULL,
  `_nbenefit` varchar(255) DEFAULT NULL,
  `_nphoto` varchar(255) DEFAULT NULL,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_nominees`
--

INSERT INTO `hrm_nominees` (`id`, `_nname`, `_nfather`, `_nmother`, `_ndob`, `_nnationalid`, `_nmobile`, `_naddress1`, `_naddress2`, `_nrelation`, `_nbenefit`, `_nphoto`, `_employee_id`, `_user`, `created_at`, `updated_at`, `_status`) VALUES
(1, '', '', '', '0000-00-00', '', '', '', '', '', '', NULL, 12, 0, '2025-05-16 09:33:39', '2025-05-16 09:33:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hrm_payheads`
--

CREATE TABLE `hrm_payheads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_ledger` varchar(255) DEFAULT NULL,
  `_type` varchar(255) DEFAULT NULL,
  `_calculation` varchar(255) DEFAULT NULL,
  `_onhead` longtext DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_ledger_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_payheads`
--

INSERT INTO `hrm_payheads` (`id`, `_ledger`, `_type`, `_calculation`, `_onhead`, `_user`, `_status`, `created_at`, `updated_at`, `_ledger_id`) VALUES
(1, 'Basic‎', '1', '', '', 46, 1, '2023-11-15 19:25:59', '2025-05-15 21:22:07', 14),
(2, 'House Rent‎', '1', '', '', 46, 1, '2023-11-15 19:27:52', '2023-11-15 19:27:52', 0),
(3, 'Medical‎', '1', '', '', 46, 1, '2023-11-15 19:28:03', '2023-11-15 19:28:03', 0),
(4, 'Conveyance', '1', '', '', 46, 1, '2023-11-15 19:28:14', '2023-11-15 19:28:14', 0),
(5, 'Over Time', '2', '', '', 46, 1, '2023-11-15 19:28:36', '2023-11-15 19:28:36', 0),
(6, 'Night Shift‎', '2', '', '', 46, 1, '2023-11-15 19:28:45', '2023-11-15 19:28:45', 0),
(7, 'Fixed OT‎', '2', '', '', 46, 1, '2023-11-15 19:28:56', '2023-11-15 19:28:56', 0),
(8, 'Fixed Allowance‎', '2', '', '', 46, 1, '2023-11-15 19:29:05', '2023-11-15 19:29:05', 0),
(9, 'Entertainment‎', '2', '', '', 46, 1, '2023-11-15 19:29:13', '2023-11-15 19:29:13', 0),
(10, 'Incentive‎', '2', '', '', 46, 1, '2023-11-15 19:29:22', '2023-11-15 19:29:22', 0),
(11, 'Arrear‎', '2', '', '', 46, 1, '2023-11-15 19:29:31', '2023-11-15 19:29:31', 0),
(12, 'Due Salary‎', '2', '', '', 46, 1, '2023-11-15 19:29:42', '2023-11-15 19:29:42', 0),
(13, 'Technical‎', '2', '', '', 46, 1, '2023-11-15 19:29:52', '2023-11-15 19:29:52', 0),
(14, 'Fuel‎', '2', '', '', 46, 1, '2023-11-15 19:30:01', '2023-11-15 19:30:01', 0),
(15, 'Other‎', '2', '', '', 46, 1, '2023-11-15 19:30:09', '2023-11-15 19:30:09', 0),
(16, 'Loan‎/‎Advance‎', '3', '', '', 46, 1, '2023-11-15 19:30:20', '2023-11-15 19:30:20', 0),
(17, 'Absent‎', '3', '', '', 46, 1, '2023-11-15 19:30:32', '2023-11-15 19:30:32', 0),
(18, 'Join‎/‎Resign‎', '3', '', '', 46, 1, '2023-11-15 19:30:43', '2023-11-15 19:30:43', 0),
(19, 'Security Deposit‎', '3', '', '', 46, 1, '2023-11-15 19:30:54', '2023-11-15 19:30:54', 0),
(20, 'Canteen‎', '3', '', '', 46, 1, '2023-11-15 19:31:04', '2023-11-15 19:31:04', 0),
(21, 'Adjustment‎', '3', '', '', 46, 1, '2023-11-15 19:31:14', '2023-11-15 19:31:14', 0),
(22, 'TDS‎', '3', '', '', 46, 1, '2023-11-15 19:31:23', '2023-11-15 19:31:23', 0),
(23, 'LWP‎', '3', '', '', 46, 1, '2023-11-15 19:31:33', '2023-11-15 19:31:33', 0),
(24, 'Other‎ Deduction', '3', '', '', 46, 1, '2023-11-15 19:31:47', '2023-11-15 19:31:47', 0),
(25, 'Extra Payment', '1', '', '', 46, 1, '2023-11-19 19:52:21', '2023-11-19 19:52:21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `hrm_payinfos`
--

CREATE TABLE `hrm_payinfos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_ledger` int(11) NOT NULL DEFAULT 0,
  `_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_period` varchar(255) DEFAULT NULL,
  `_effect` tinyint(4) NOT NULL DEFAULT 0,
  `_payheads` int(11) NOT NULL DEFAULT 0,
  `_payinfo_id` int(11) NOT NULL DEFAULT 0,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_payunits`
--

CREATE TABLE `hrm_payunits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_unit` varchar(255) DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_pay_head_types`
--

CREATE TABLE `hrm_pay_head_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `cal_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1=Add,2=Deduction',
  `_status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_pay_head_types`
--

INSERT INTO `hrm_pay_head_types` (`id`, `_name`, `cal_type`, `_status`, `created_at`, `updated_at`) VALUES
(1, 'Salaries', 1, 1, NULL, NULL),
(2, 'Allowance', 1, 1, NULL, NULL),
(3, 'Deduction', 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hrm_profitcenters`
--

CREATE TABLE `hrm_profitcenters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_recruitments`
--

CREATE TABLE `hrm_recruitments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_contactno` varchar(255) DEFAULT NULL,
  `_email` varchar(255) DEFAULT NULL,
  `_vacancy` int(11) NOT NULL DEFAULT 0,
  `_resume` longtext DEFAULT NULL,
  `_comment` longtext DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_qualification` varchar(255) DEFAULT NULL,
  `_experience` varchar(255) DEFAULT NULL,
  `_salary` double(15,4) NOT NULL DEFAULT 0.0000,
  `_selected` tinyint(4) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_rewards`
--

CREATE TABLE `hrm_rewards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_rcategory` varchar(255) DEFAULT NULL,
  `_rtype` varchar(255) DEFAULT NULL,
  `_rcause` varchar(255) DEFAULT NULL,
  `_rnote` longtext DEFAULT NULL,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_salarystructures`
--

CREATE TABLE `hrm_salarystructures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_month` varchar(255) DEFAULT NULL,
  `_year` varchar(255) DEFAULT NULL,
  `_paydays` double(15,4) NOT NULL DEFAULT 0.0000,
  `_arrdays` double(15,4) NOT NULL DEFAULT 0.0000,
  `_verify` varchar(255) DEFAULT NULL,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_sstructuredetails`
--

CREATE TABLE `hrm_sstructuredetails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_ledger` int(11) NOT NULL DEFAULT 0,
  `_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_structureno` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_trainings`
--

CREATE TABLE `hrm_trainings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_type` varchar(255) DEFAULT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_subject` varchar(255) DEFAULT NULL,
  `_organized` varchar(255) DEFAULT NULL,
  `_place` varchar(255) DEFAULT NULL,
  `_trfrom` varchar(255) DEFAULT NULL,
  `_trto` varchar(255) DEFAULT NULL,
  `_result` varchar(255) DEFAULT NULL,
  `_note` longtext DEFAULT NULL,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_transfers`
--

CREATE TABLE `hrm_transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_tfrom` varchar(255) DEFAULT NULL,
  `_tto` varchar(255) DEFAULT NULL,
  `_ttransfer` date DEFAULT NULL,
  `_tjoin` date DEFAULT NULL,
  `_tnote` longtext DEFAULT NULL,
  `_employee_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_forganization_id` int(11) NOT NULL DEFAULT 0,
  `_fbranch_id` int(11) NOT NULL DEFAULT 0,
  `_fcost_center_id` int(11) NOT NULL DEFAULT 0,
  `_torganization_id` int(11) NOT NULL DEFAULT 0,
  `_tbranch_id` int(11) NOT NULL DEFAULT 0,
  `_tcost_center_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_vacancies`
--

CREATE TABLE `hrm_vacancies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_jobtitle` int(11) NOT NULL DEFAULT 0,
  `_hiring` int(11) NOT NULL DEFAULT 0,
  `_nop` int(11) NOT NULL DEFAULT 0,
  `_description` longtext DEFAULT NULL,
  `_active` tinyint(4) NOT NULL DEFAULT 0,
  `_department_id` int(11) NOT NULL DEFAULT 0,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hrm_weekworkdays`
--

CREATE TABLE `hrm_weekworkdays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_monday` varchar(10) DEFAULT NULL,
  `_tuesday` varchar(10) DEFAULT NULL,
  `_wednesday` varchar(10) DEFAULT NULL,
  `_thursday` varchar(10) DEFAULT NULL,
  `_friday` varchar(10) DEFAULT NULL,
  `_saturday` varchar(10) DEFAULT NULL,
  `_sunday` varchar(10) DEFAULT NULL,
  `_user` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hrm_weekworkdays`
--

INSERT INTO `hrm_weekworkdays` (`id`, `_monday`, `_tuesday`, `_wednesday`, `_thursday`, `_friday`, `_saturday`, `_sunday`, `_user`, `created_at`, `updated_at`) VALUES
(1, 'on', 'on', 'on', 'on', 'on', 'off', 'on', 1, NULL, '2023-09-13 04:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `import_cost_accounts`
--

CREATE TABLE `import_cost_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double NOT NULL DEFAULT 0,
  `_cr_amount` double NOT NULL DEFAULT 0,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `import_cost_ledgers`
--

CREATE TABLE `import_cost_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_insurance_bdt_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_lc_commision_bdt_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_custom_duty_bdt_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_custom_duty_tax_ait_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_custom_duty_tax_ait_2nd_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_customer_other_charge_other_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_port_charge_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_port_charge_ait_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_shiping_agent_charge_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_shiping_agent_deduction_charge_2nd_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_deport_charge_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_container_damage_charge_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_cnf_agen_commision_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_installation_cost_ledger_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `import_puchases`
--

CREATE TABLE `import_puchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` varchar(255) DEFAULT NULL,
  `_purchase_type` varchar(255) DEFAULT NULL COMMENT 'Local,Import',
  `_po_number` varchar(255) DEFAULT NULL,
  `_rlp_no` varchar(255) DEFAULT NULL,
  `_note_sheet_no` varchar(255) DEFAULT NULL,
  `_workorder_no` varchar(255) DEFAULT NULL,
  `_lc_no` varchar(255) DEFAULT NULL,
  `_vessel_no` varchar(255) DEFAULT NULL,
  `_capacity` double(15,4) NOT NULL DEFAULT 0.0000,
  `_arrival_date_time` varchar(255) DEFAULT NULL,
  `_discharge_date_time` varchar(255) DEFAULT NULL,
  `_referance` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_address` varchar(100) DEFAULT NULL,
  `_phone` varchar(60) DEFAULT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` longtext DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_expected_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_sd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_cd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_ait_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_rd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_at_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_tti_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_l_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_cost_center_id` int(11) NOT NULL DEFAULT 1,
  `_store_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `import_puchase_accounts`
--

CREATE TABLE `import_puchase_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `import_puchase_barcodes`
--

CREATE TABLE `import_puchase_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `import_puchase_details`
--

CREATE TABLE `import_puchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` double(15,4) NOT NULL DEFAULT 0.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_barcode` longtext DEFAULT NULL,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_expected_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_ait` double(15,4) NOT NULL DEFAULT 0.0000,
  `_ait_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_at` double(15,4) NOT NULL DEFAULT 0.0000,
  `_at_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_tti` double(15,4) NOT NULL DEFAULT 0.0000,
  `_tti_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_short_note` varchar(150) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `import_puchase_form_settings`
--

CREATE TABLE `import_puchase_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_default_inventory` int(11) NOT NULL DEFAULT 0,
  `_default_purchase` int(11) NOT NULL DEFAULT 0,
  `_default_discount` int(11) NOT NULL DEFAULT 0,
  `_default_vat_account` int(11) NOT NULL DEFAULT 0,
  `_default_sd_account` int(11) NOT NULL DEFAULT 0,
  `_default_cd_account` int(11) NOT NULL DEFAULT 0,
  `_default_ait_account` int(11) NOT NULL DEFAULT 0,
  `_default_rd_account` int(11) NOT NULL DEFAULT 0,
  `_default_tti_account` int(11) NOT NULL DEFAULT 0,
  `_opening_inventory` int(11) NOT NULL DEFAULT 0,
  `_default_capital` int(11) NOT NULL DEFAULT 0,
  `_show_barcode` int(11) NOT NULL DEFAULT 0,
  `_inline_discount` tinyint(4) NOT NULL DEFAULT 0,
  `_show_vat` int(11) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL DEFAULT 0,
  `_show_self` int(11) NOT NULL DEFAULT 0,
  `_show_sd` int(11) NOT NULL DEFAULT 0,
  `_show_cd` int(11) NOT NULL DEFAULT 0,
  `_show_ait` int(11) NOT NULL DEFAULT 0,
  `_show_expected_qty` int(11) NOT NULL DEFAULT 0,
  `_show_rd` int(11) NOT NULL DEFAULT 0,
  `_show_at` int(11) NOT NULL DEFAULT 0,
  `_show_tti` int(11) NOT NULL DEFAULT 0,
  `_show_manufacture_date` int(11) NOT NULL DEFAULT 0,
  `_show_expire_date` int(11) NOT NULL DEFAULT 0,
  `_show_sales_rate` tinyint(4) NOT NULL DEFAULT 0,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_p_balance` tinyint(4) NOT NULL DEFAULT 0,
  `_show_po` tinyint(4) NOT NULL DEFAULT 0,
  `_show_rlp` tinyint(4) NOT NULL DEFAULT 0,
  `_show_note_sheet` tinyint(4) NOT NULL DEFAULT 0,
  `_show_wo` tinyint(4) NOT NULL DEFAULT 0,
  `_show_lc` tinyint(4) NOT NULL DEFAULT 0,
  `_show_vn` tinyint(4) NOT NULL DEFAULT 0,
  `_invoice_template` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `import_puchase_form_settings`
--

INSERT INTO `import_puchase_form_settings` (`id`, `organization_id`, `_default_inventory`, `_default_purchase`, `_default_discount`, `_default_vat_account`, `_default_sd_account`, `_default_cd_account`, `_default_ait_account`, `_default_rd_account`, `_default_tti_account`, `_opening_inventory`, `_default_capital`, `_show_barcode`, `_inline_discount`, `_show_vat`, `_show_store`, `_show_self`, `_show_sd`, `_show_cd`, `_show_ait`, `_show_expected_qty`, `_show_rd`, `_show_at`, `_show_tti`, `_show_manufacture_date`, `_show_expire_date`, `_show_sales_rate`, `_show_unit`, `_show_p_balance`, `_show_po`, `_show_rlp`, `_show_note_sheet`, `_show_wo`, `_show_lc`, `_show_vn`, `_invoice_template`, `created_at`, `updated_at`) VALUES
(1, 0, 6, 2, 11, 9, 0, 0, 0, 0, 0, 10, 10, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 3, NULL, '2023-11-15 10:41:52');

-- --------------------------------------------------------

--
-- Table structure for table `import_receive_vessel_infos`
--

CREATE TABLE `import_receive_vessel_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_vessel_no` int(11) NOT NULL DEFAULT 0,
  `_vessel_res_person` varchar(255) DEFAULT NULL,
  `_vessel_res_mobile` varchar(255) DEFAULT NULL,
  `_extra_instruction` longtext DEFAULT NULL,
  `_purchase_no` int(11) NOT NULL DEFAULT 0,
  `_capacity` double(15,4) NOT NULL DEFAULT 0.0000,
  `scott_name` varchar(255) DEFAULT NULL,
  `scott_number` varchar(255) DEFAULT NULL,
  `servey_name` varchar(255) DEFAULT NULL,
  `servey_number` varchar(255) DEFAULT NULL,
  `boat_no` varchar(255) DEFAULT NULL,
  `boat_file` varchar(255) DEFAULT NULL,
  `servey_file` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incentive_earn_ledger_details`
--

CREATE TABLE `incentive_earn_ledger_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_account_type_id` int(11) NOT NULL DEFAULT 0,
  `_account_group_id` int(11) NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_dr_amount` double NOT NULL DEFAULT 0,
  `_cr_amount` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `incentive_earn_masters`
--

CREATE TABLE `incentive_earn_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date NOT NULL,
  `_time` varchar(255) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_fescal_year` varchar(255) DEFAULT NULL,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_term_condition` longtext DEFAULT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_sub_total` double NOT NULL DEFAULT 0,
  `_total` double NOT NULL DEFAULT 0,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_receive_type` varchar(60) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `individual_replace_form_settings`
--

CREATE TABLE `individual_replace_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_rep_manage_account` int(11) NOT NULL,
  `_default_sales_dicount` int(11) NOT NULL,
  `_default_cost_of_solds` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL,
  `_inline_discount` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL,
  `_show_short_note` int(11) NOT NULL DEFAULT 1,
  `_show_vat` int(11) NOT NULL,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `_show_delivery_man` int(11) NOT NULL,
  `_show_sales_man` int(11) NOT NULL,
  `_show_cost_rate` int(11) NOT NULL,
  `_invoice_template` int(11) NOT NULL,
  `_show_warranty` int(11) NOT NULL,
  `_show_manufacture_date` int(11) NOT NULL,
  `_show_expire_date` int(11) NOT NULL,
  `_show_p_balance` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_is_header` tinyint(4) NOT NULL DEFAULT 0,
  `_is_footer` tinyint(4) NOT NULL DEFAULT 0,
  `_margin_top` varchar(30) DEFAULT NULL,
  `_margin_bottom` varchar(30) DEFAULT NULL,
  `_margin_left` varchar(30) DEFAULT NULL,
  `_margin_right` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `individual_replace_form_settings`
--

INSERT INTO `individual_replace_form_settings` (`id`, `_default_rep_manage_account`, `_default_sales_dicount`, `_default_cost_of_solds`, `_default_discount`, `_default_vat_account`, `_inline_discount`, `_show_barcode`, `_show_short_note`, `_show_vat`, `_show_unit`, `_show_store`, `_show_self`, `_show_delivery_man`, `_show_sales_man`, `_show_cost_rate`, `_invoice_template`, `_show_warranty`, `_show_manufacture_date`, `_show_expire_date`, `_show_p_balance`, `created_at`, `updated_at`, `_is_header`, `_is_footer`, `_margin_top`, `_margin_bottom`, `_margin_left`, `_margin_right`) VALUES
(1, 438, 8, 1, 1, 10, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1, NULL, '2023-04-24 19:47:25', 0, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `individual_replace_in_accounts`
--

CREATE TABLE `individual_replace_in_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `individual_replace_in_items`
--

CREATE TABLE `individual_replace_in_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_time` varchar(50) DEFAULT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_net_total` float NOT NULL DEFAULT 0,
  `_adjustment_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_barcode` varchar(255) DEFAULT NULL,
  `_short_note` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_in_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_in_payment_amount` float NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_in_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `individual_replace_masters`
--

CREATE TABLE `individual_replace_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0 COMMENT 'Complain Number',
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_customer_id` bigint(20) UNSIGNED NOT NULL,
  `_supplier_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_service_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_apporoved_by` int(11) NOT NULL DEFAULT 0,
  `_service_by` varchar(255) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `individual_replace_old_items`
--

CREATE TABLE `individual_replace_old_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_barcode` varchar(255) DEFAULT NULL,
  `_short_note` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_sales_ref_id` int(11) NOT NULL DEFAULT 0,
  `_sales_detail_ref_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_warranty_date` date DEFAULT NULL,
  `_sales_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_warranty_comment` varchar(250) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `individual_replace_out_accounts`
--

CREATE TABLE `individual_replace_out_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `individual_replace_out_items`
--

CREATE TABLE `individual_replace_out_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date DEFAULT NULL,
  `_time` varchar(50) DEFAULT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_adjustment_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_net_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_barcode` varchar(255) DEFAULT NULL,
  `_short_note` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_out_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_out_payment_amount` double NOT NULL DEFAULT 0,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_out_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspection_check_categories`
--

CREATE TABLE `inspection_check_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inspection_check_lists`
--

CREATE TABLE `inspection_check_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `ins_category_id` int(11) NOT NULL DEFAULT 0,
  `code` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item` varchar(200) NOT NULL,
  `_generic_name` varchar(200) DEFAULT NULL,
  `_strength` varchar(200) DEFAULT NULL,
  `_item_category` varchar(200) DEFAULT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_unit_id` int(11) NOT NULL,
  `_barcode` varchar(255) DEFAULT NULL,
  `_category_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `_image` varchar(200) DEFAULT NULL,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_ait` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_at` double(15,4) NOT NULL DEFAULT 0.0000,
  `_tti` double(15,4) NOT NULL DEFAULT 0.0000,
  `_pur_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sale_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_opening_qty` float(15,4) NOT NULL DEFAULT 0.0000,
  `_reorder` double(15,4) NOT NULL DEFAULT 0.0000,
  `_order_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_manufacture_company` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_used` tinyint(4) NOT NULL DEFAULT 0,
  `_unique_barcode` tinyint(4) NOT NULL DEFAULT 0,
  `_kitchen_item` tinyint(4) NOT NULL DEFAULT 0 COMMENT 'if 1 then this item will send to kitchen to cook/production and store deduct as per item ingredient wise ',
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_serial` int(11) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_description` varchar(255) DEFAULT NULL,
  `_oringin` varchar(255) DEFAULT NULL,
  `_model` varchar(150) DEFAULT NULL,
  `_item_type` int(11) NOT NULL DEFAULT 0,
  `_category_id_4` int(11) NOT NULL DEFAULT 0,
  `_category_id_3` int(11) NOT NULL DEFAULT 0,
  `_category_id_2` int(11) NOT NULL DEFAULT 0,
  `_category_id_1` int(11) NOT NULL DEFAULT 0,
  `_pack_size_id` int(11) NOT NULL DEFAULT 0,
  `_brand_id` int(11) NOT NULL DEFAULT 0,
  `_trade_price` double(15,4) NOT NULL DEFAULT 0.0000,
  `_mrp_price` double(15,4) NOT NULL DEFAULT 0.0000,
  `_hs_code` varchar(200) DEFAULT NULL,
  `_hs_code_2` varchar(100) DEFAULT NULL,
  `_second_unit_qty` float(15,4) NOT NULL DEFAULT 0.0000,
  `_second_unit_id` int(11) NOT NULL DEFAULT 0,
  `_curum` varchar(200) DEFAULT NULL,
  `_length` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_invoice_master_id` int(11) NOT NULL DEFAULT 0,
  `_invoice_master_number` varchar(255) DEFAULT NULL,
  `_ref_id` int(11) NOT NULL DEFAULT 0,
  `_tran_type` tinyint(4) NOT NULL DEFAULT 0,
  `_table_name` varchar(255) DEFAULT NULL,
  `_amount` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_prefixes`
--

CREATE TABLE `invoice_prefixes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_table_name` varchar(255) NOT NULL,
  `_prefix` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_prefixes`
--

INSERT INTO `invoice_prefixes` (`id`, `_table_name`, `_prefix`, `created_at`, `updated_at`) VALUES
(1, 'purchases', 'P-', NULL, '2023-02-10 04:17:27'),
(2, 'purchase_returns', 'PR-', NULL, '2023-02-10 04:17:39'),
(3, 'sales', 'INV-', NULL, '2023-02-10 04:17:18'),
(4, 'sales_returns', 'SR-', NULL, '2023-02-10 04:17:39'),
(5, 'resturant_sales', 'RS-', NULL, '2023-02-10 04:17:39'),
(6, 'productions', 'PD-', NULL, '2023-02-10 04:17:39'),
(7, 'transfer', 'TF-', NULL, '2023-02-10 04:17:39'),
(8, 'individual_replace_masters', 'IR-', NULL, '2023-02-10 04:17:39'),
(9, 'voucher_masters', 'AC-', NULL, '2023-02-10 04:17:39'),
(10, 'purchase_orders', 'PO-', NULL, '2023-02-10 04:17:39'),
(11, 'warranty_masters', 'W-', NULL, '2023-02-10 04:17:39'),
(12, 'replacement_masters', 'RP-', NULL, '2023-02-10 04:17:39'),
(13, 'service_masters', 'SERVICE-', NULL, '2023-02-10 04:17:39'),
(14, 'damage_adjustments', 'DM-', NULL, '2023-02-10 04:17:39'),
(15, 'material_issues', 'MI-', NULL, '2023-10-17 08:54:51'),
(16, 'material_issue_returns', 'MIR-', NULL, '2023-10-17 08:54:51'),
(17, 'supplier_payments', 'SP-', NULL, '2024-12-30 12:21:39'),
(18, 'receive_payments', 'CR-', NULL, '2024-12-30 12:21:39'),
(19, 'stm_bill_masters', 'BILL-', NULL, '2024-07-17 09:22:42'),
(20, 'stm_collection_masters', 'MR-', NULL, '2025-05-03 23:13:33');

-- --------------------------------------------------------

--
-- Table structure for table `item_balance_without_lots`
--

CREATE TABLE `item_balance_without_lots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_bonus_setups`
--

CREATE TABLE `item_bonus_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_date` date DEFAULT NULL,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 1,
  `_qty_slot_min` double NOT NULL DEFAULT 0,
  `_qty_slot_max` double NOT NULL DEFAULT 0,
  `_start_time` date NOT NULL,
  `_end_time` date NOT NULL,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `receive_or_paid` tinyint(4) NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `_allow_all_branch` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_brands`
--

CREATE TABLE `item_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_detail` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL,
  `_parent_id` int(11) NOT NULL DEFAULT 0,
  `_name` varchar(255) NOT NULL,
  `_image` varchar(255) DEFAULT NULL,
  `_description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_code` varchar(100) DEFAULT NULL,
  `asset_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_dep_ledger_id` int(11) NOT NULL DEFAULT 0,
  `asset_dep_exp_ledger_id` int(11) NOT NULL DEFAULT 0,
  `dep_rate` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_inventories`
--

CREATE TABLE `item_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_item_name` varchar(255) NOT NULL,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_category_id` int(11) NOT NULL,
  `_date` date NOT NULL,
  `_time` varchar(255) NOT NULL,
  `_transection` varchar(255) NOT NULL,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_transection_ref` int(11) NOT NULL,
  `_transection_detail_ref_id` int(11) NOT NULL,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cost_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cost_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_pack_size_id` int(11) NOT NULL DEFAULT 0,
  `_brand_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_item_code` varchar(100) DEFAULT NULL,
  `_short_note` varchar(255) DEFAULT NULL,
  `_sales_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_pack_sizes`
--

CREATE TABLE `item_pack_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_detail` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_rate_histories`
--

CREATE TABLE `item_rate_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_item_code` varchar(30) DEFAULT NULL,
  `_effective_date` date NOT NULL,
  `_pur_rate` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_comment` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_update` tinyint(4) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_created_by` int(11) NOT NULL DEFAULT 0,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_rate_history_logs`
--

CREATE TABLE `item_rate_history_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_effective_date` date NOT NULL,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_comment` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_created_by` int(11) NOT NULL DEFAULT 0,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_types`
--

CREATE TABLE `item_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_detail` longtext DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_types`
--

INSERT INTO `item_types` (`id`, `_name`, `_code`, `_detail`, `_status`, `_is_delete`, `created_at`, `updated_at`) VALUES
(1, 'Row Materials', 'RM', 'N/A', 1, 0, '2023-11-16 11:34:06', '2023-11-16 11:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `kitchens`
--

CREATE TABLE `kitchens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_res_sales_id` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kitchen_finish_goods`
--

CREATE TABLE `kitchen_finish_goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_warranty` varchar(255) NOT NULL DEFAULT '0',
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_coking` tinyint(4) NOT NULL DEFAULT 0,
  `_kitchen_item` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kitchen_row_goods`
--

CREATE TABLE `kitchen_row_goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `_conversion_qty` decimal(15,4) NOT NULL DEFAULT 1.0000,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_warranty` varchar(255) NOT NULL DEFAULT '0',
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_kitchen_item` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL DEFAULT 0,
  `lang_name` varchar(120) NOT NULL,
  `lang_locale` varchar(20) NOT NULL,
  `lang_code` varchar(20) NOT NULL,
  `lang_flag` varchar(20) DEFAULT NULL,
  `lang_is_default` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `lang_order` int(11) NOT NULL DEFAULT 0,
  `lang_is_rtl` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `language_meta`
--

CREATE TABLE `language_meta` (
  `lang_meta_id` int(10) UNSIGNED NOT NULL,
  `lang_meta_code` text DEFAULT NULL,
  `lang_meta_origin` varchar(255) NOT NULL,
  `reference_id` int(10) UNSIGNED NOT NULL,
  `reference_type` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lc_amendments`
--

CREATE TABLE `lc_amendments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lc_master_id` bigint(20) UNSIGNED NOT NULL,
  `amendment_no` varchar(255) NOT NULL,
  `amendment_date` date NOT NULL,
  `amendment_type` varchar(255) NOT NULL,
  `old_cif_value_foreign` double NOT NULL DEFAULT 0,
  `new_cif_value_foreign` double NOT NULL DEFAULT 0,
  `old_expiry_date` date DEFAULT NULL,
  `new_expiry_date` date DEFAULT NULL,
  `reason_for_amendment` varchar(255) DEFAULT NULL,
  `created_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lc_amendment_types`
--

CREATE TABLE `lc_amendment_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_detail` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lc_items`
--

CREATE TABLE `lc_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lc_master_id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_item_code` varchar(50) DEFAULT NULL,
  `_item_name` varchar(255) DEFAULT NULL,
  `_unit_conversion` decimal(10,0) NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` decimal(10,0) NOT NULL DEFAULT 0,
  `_qty` decimal(10,0) NOT NULL DEFAULT 0,
  `_category_id` int(11) NOT NULL DEFAULT 0,
  `_short_note` varchar(255) DEFAULT NULL,
  `item_quantity` decimal(10,0) NOT NULL DEFAULT 0,
  `_rate` decimal(10,0) NOT NULL DEFAULT 0,
  `_foreign_rate` decimal(10,0) NOT NULL DEFAULT 0,
  `_foreign_amount` decimal(10,0) NOT NULL DEFAULT 0,
  `_value` decimal(10,0) NOT NULL DEFAULT 0,
  `_barcode` varchar(255) DEFAULT NULL,
  `_hs_code` varchar(255) DEFAULT NULL,
  `_hs_code_2` varchar(255) DEFAULT NULL,
  `hs_code2` varchar(255) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `weight_avg` decimal(10,0) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lc_item_costs`
--

CREATE TABLE `lc_item_costs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lc_master_id` bigint(20) UNSIGNED NOT NULL,
  `_lc_item_id` int(11) NOT NULL DEFAULT 0,
  `_lc_stage_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(100) DEFAULT NULL,
  `_cost_deduct_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_adjust_type` tinyint(4) NOT NULL DEFAULT 0,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_item_code` varchar(255) DEFAULT NULL,
  `_unit_conversion` decimal(10,0) NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` decimal(10,0) NOT NULL DEFAULT 0,
  `_qty` decimal(10,0) NOT NULL DEFAULT 0,
  `item_quantity` decimal(10,0) NOT NULL DEFAULT 0,
  `_rate` decimal(10,0) NOT NULL DEFAULT 0,
  `_foreign_rate` decimal(10,0) NOT NULL DEFAULT 0,
  `_foreign_amount` decimal(10,0) NOT NULL DEFAULT 0,
  `_value` decimal(10,0) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lc_masters`
--

CREATE TABLE `lc_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_voucher_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(100) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_date` date DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `lc_ip_no` varchar(255) NOT NULL,
  `lc_ip_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `amendment_date` date DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  `pi_no` varchar(255) NOT NULL,
  `pi_date` date DEFAULT NULL,
  `bill_of_enty_no` varchar(255) DEFAULT NULL,
  `bill_of_enty_date` date DEFAULT NULL,
  `date_of_arrival` date DEFAULT NULL,
  `lc_type` varchar(255) DEFAULT NULL,
  `lca_no` varchar(255) DEFAULT NULL,
  `transport_type` varchar(255) NOT NULL,
  `partial_shipment` varchar(255) DEFAULT NULL,
  `bank` int(11) NOT NULL DEFAULT 0,
  `supplier` int(11) NOT NULL DEFAULT 0,
  `cnf` int(11) NOT NULL DEFAULT 0,
  `bank_branch` varchar(255) DEFAULT NULL,
  `insurance_company` int(11) NOT NULL DEFAULT 0,
  `insurance_cover_note` varchar(255) DEFAULT NULL,
  `insurance_cover_date` date DEFAULT NULL,
  `lc_tt` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `_cif_value_foreign` double NOT NULL DEFAULT 0,
  `_cif_value_local` double NOT NULL DEFAULT 0,
  `_rate_to_bdt` double NOT NULL DEFAULT 0,
  `_local_amount` double NOT NULL DEFAULT 0,
  `remark` text DEFAULT NULL,
  `_note` varchar(200) DEFAULT NULL,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(100) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_is_posting` tinyint(4) NOT NULL DEFAULT 0,
  `amendment_no` varchar(200) DEFAULT 'NULL'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `main_account_head`
--

CREATE TABLE `main_account_head` (
  `id` int(11) NOT NULL,
  `_name` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `_serial` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `main_account_head`
--

INSERT INTO `main_account_head` (`id`, `_name`, `created_at`, `updated_at`, `_serial`) VALUES
(1, 'Assets', '2022-03-17 16:00:58', '2022-03-17 16:00:58', 0),
(2, 'Liability', '2022-03-17 16:00:58', '2022-03-17 16:00:58', 0),
(3, 'Income', '2022-03-17 16:00:58', '2022-03-17 16:00:58', 0),
(4, 'Expenses', '2022-03-17 16:00:58', '2022-03-17 16:00:58', 0),
(5, 'Capital', '2022-03-17 16:00:58', '2022-03-17 16:00:58', 0);

-- --------------------------------------------------------

--
-- Table structure for table `material_issues`
--

CREATE TABLE `material_issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_payment_terms` int(11) NOT NULL DEFAULT 1,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_delivery_details` text DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_l_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_issues`
--

INSERT INTO `material_issues` (`id`, `_order_number`, `_date`, `_time`, `_order_ref_id`, `_payment_terms`, `_referance`, `_address`, `_phone`, `_delivery_details`, `_ledger_id`, `_user_id`, `_user_name`, `_note`, `_sub_total`, `_discount_input`, `_total_discount`, `_total_vat`, `_total`, `_p_balance`, `_l_balance`, `_branch_id`, `_store_id`, `organization_id`, `_cost_center_id`, `_store_salves_id`, `_delivery_man_id`, `_sales_man_id`, `_sales_type`, `_status`, `_lock`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(1, 'MI-SPL-RED-02', '2024-04-24', '14:29:16', 0, 1, NULL, NULL, 'null', '', 30, 46, 'Admin', 'Issue', 2060.0000, 0.0000, 0.0000, 0.0000, 2060.0000, 2060.0000, 4120.0000, 1, 0, 1, 26, NULL, 0, 0, 'material_issue', 1, 0, '46-Admin', NULL, '2024-04-24 08:20:04', '2024-04-24 08:29:16'),
(2, 'MI-SPL-RED-03', '2024-04-24', '14:28:48', 0, 1, NULL, NULL, 'null', '', 30, 46, 'Admin', 'issue', 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 2060.0000, 2060.0000, 1, 0, 1, 26, NULL, 0, 0, 'material_issue', 1, 0, '46-Admin', NULL, '2024-04-24 08:26:19', '2024-04-24 08:28:48');

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_barcodes`
--

CREATE TABLE `material_issue_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_details`
--

CREATE TABLE `material_issue_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_issue_details`
--

INSERT INTO `material_issue_details` (`id`, `_item_id`, `_p_p_l_id`, `_transection_unit`, `_unit_conversion`, `_base_unit`, `_base_rate`, `_qty`, `_rate`, `_sales_rate`, `_discount`, `_discount_amount`, `_vat`, `_vat_amount`, `_value`, `_store_id`, `_warranty`, `_store_salves_id`, `_barcode`, `_purchase_invoice_no`, `_purchase_detail_id`, `_manufacture_date`, `_expire_date`, `_no`, `organization_id`, `_cost_center_id`, `_branch_id`, `_status`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(1, 74, 6, 10, 1, 10, 1030, 2.0000, 1030.0000, 1030.0000, 0.0000, 0.0000, 0.0000, 0.0000, 2060.0000, 1, 0, '', '', 2, 6, NULL, NULL, 1, 1, 26, 1, 1, '46-Admin', NULL, '2024-04-24 08:20:04', '2024-04-24 08:29:16'),
(2, 6, 7, 2, 1, 2, 0, 3.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 0.0000, 1, 0, '', '', 1, 1, NULL, NULL, 2, 1, 26, 1, 1, '46-Admin', NULL, '2024-04-24 08:26:19', '2024-04-24 08:28:48');

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_returns`
--

CREATE TABLE `material_issue_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_delivery_details` longtext DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_l_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_return_barcodes`
--

CREATE TABLE `material_issue_return_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_return_details`
--

CREATE TABLE `material_issue_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_sales_ref_id` int(11) NOT NULL DEFAULT 0,
  `_sales_detail_ref_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_vat_amount` double NOT NULL DEFAULT 0,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_barcode` longtext DEFAULT NULL,
  `_warranty` varchar(255) NOT NULL DEFAULT '0',
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` int(11) NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_cost_center_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_return_settings`
--

CREATE TABLE `material_issue_return_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL,
  `_default_issue_ledger` int(11) NOT NULL,
  `_default_cost_of_solds` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL,
  `_inline_discount` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL,
  `_show_vat` int(11) NOT NULL,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `_show_delivery_man` int(11) NOT NULL,
  `_show_sales_man` int(11) NOT NULL,
  `_show_cost_rate` int(11) NOT NULL,
  `_invoice_template` int(11) NOT NULL,
  `_show_warranty` int(11) NOT NULL,
  `_show_manufacture_date` int(11) NOT NULL,
  `_show_payment_terms` int(11) NOT NULL,
  `_show_expire_date` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `material_issue_settings`
--

CREATE TABLE `material_issue_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL,
  `_default_sales` int(11) NOT NULL COMMENT 'Default Issue Ledger',
  `_default_cost_of_solds` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL,
  `_inline_discount` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL,
  `_show_vat` int(11) NOT NULL,
  `_show_unit` int(11) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_branch` int(11) NOT NULL DEFAULT 0,
  `_show_cost_center` int(11) NOT NULL DEFAULT 0,
  `_show_self` int(11) NOT NULL,
  `_show_delivery_man` int(11) NOT NULL,
  `_show_sales_man` int(11) NOT NULL,
  `_show_cost_rate` int(11) NOT NULL,
  `_invoice_template` int(11) NOT NULL,
  `_show_warranty` int(11) NOT NULL,
  `_show_manufacture_date` int(11) NOT NULL,
  `_show_payment_terms` int(11) NOT NULL,
  `_show_expire_date` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material_issue_settings`
--

INSERT INTO `material_issue_settings` (`id`, `_default_inventory`, `_default_sales`, `_default_cost_of_solds`, `_default_discount`, `_default_vat_account`, `_inline_discount`, `_show_barcode`, `_show_vat`, `_show_unit`, `_show_store`, `_show_branch`, `_show_cost_center`, `_show_self`, `_show_delivery_man`, `_show_sales_man`, `_show_cost_rate`, `_invoice_template`, `_show_warranty`, `_show_manufacture_date`, `_show_payment_terms`, `_show_expire_date`, `created_at`, `updated_at`) VALUES
(1, 6, 16, 16, 7, 9, 0, 0, 0, 1, 0, 1, 1, 0, 0, 0, 0, 5, 0, 0, 0, 0, NULL, '2024-04-24 08:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2020_10_09_135732_create_products_table', 1),
(6, '2021_05_31_063527_create_general_settings_table', 2),
(7, '2021_06_01_150128_create_boards_table', 2),
(19, '2021_06_20_180911_create_page_rows_table', 7),
(78, '2022_02_01_143528_create_branches_table', 15),
(88, '2020_10_09_135640_create_permission_tables', 16),
(89, '2021_06_06_163854_create_social_media_table', 16),
(90, '2022_02_01_144222_create_account_heads_table', 16),
(91, '2022_02_01_144223_create_account_groups_table', 16),
(92, '2022_02_01_144249_create_account_ledgers_table', 16),
(93, '2022_02_01_144312_create_purchase_orders_table', 16),
(95, '2022_02_01_144327_create_purchase_order_details_table', 16),
(96, '2022_02_01_144348_create_purchases_table', 16),
(97, '2022_02_01_144404_create_purchase_details_table', 16),
(98, '2022_02_01_144444_create_voucher_masters_table', 17),
(99, '2022_02_01_144458_create_voucher_master_details_table', 17),
(100, '2022_02_01_144610_create_sales_orders_table', 17),
(101, '2022_02_01_144624_create_sales_order_details_table', 17),
(103, '2022_02_01_144651_create_sales_table', 17),
(105, '2022_02_01_144722_create_sales_returns_table', 17),
(106, '2022_02_01_144738_create_sales_return_details_table', 17),
(107, '2022_02_01_144830_create_purchase_returns_table', 17),
(109, '2022_02_01_145002_create_proforma_sales_table', 17),
(110, '2022_02_01_145015_create_proforma_sales_details_table', 17),
(111, '2022_02_01_145150_create_item_inventories_table', 17),
(112, '2022_02_01_145216_create_default_ledgers_table', 17),
(113, '2022_02_01_145357_create_voucher_types_table', 17),
(114, '2022_02_01_145434_create_cost_centers_table', 17),
(115, '2022_02_01_145517_create_store_houses_table', 17),
(116, '2022_02_01_145606_create_store_house_selves_table', 17),
(117, '2022_03_31_155636_create_item_categories_table', 18),
(118, '2022_02_01_144326_create_inventories_table', 19),
(120, '2022_04_15_141902_create_purchase_accounts_table', 20),
(121, '2022_04_19_200104_create_purchase_return_form_settings_table', 21),
(122, '2022_04_19_202822_create_purchase_return_accounts_table', 22),
(123, '2022_04_21_183954_create_sales_form_settings_table', 23),
(124, '2022_04_22_163045_create_sales_accounts_table', 24),
(125, '2022_04_22_164221_create_sales_return_accounts_table', 25),
(126, '2022_04_22_164136_create_sales_return_form_settings_table', 26),
(127, '2022_02_01_144705_create_sales_details_table', 27),
(128, '2022_02_01_144901_create_purchase_return_details_table', 28),
(129, '2022_09_15_160511_create_table_infos_table', 29),
(130, '2022_09_15_174144_create_resturant_sales_table', 30),
(131, '2022_09_15_174249_create_resturant_details_table', 31),
(132, '2022_09_15_174454_create_kitchens_table', 32),
(133, '2022_09_15_175528_create_kitchen_finish_goods_table', 33),
(134, '2022_09_15_175551_create_kitchen_row_goods_table', 34),
(135, '2022_09_15_225434_create_musak_four_point_threes_table', 35),
(136, '2022_09_15_225531_create_musak_four_point_three_inputs_table', 36),
(137, '2022_09_15_225636_create_musak_four_point_three_additions_table', 37),
(138, '2022_09_15_235243_create_resturant_form_settings_table', 38),
(139, '2022_09_19_174545_create_steward_allocations_table', 39),
(140, '2022_04_22_163045_create_resturant_sales_accounts_table', 40),
(141, '2022_10_10_231802_create_unit_conversions_table', 41),
(142, '2022_10_23_091959_create_restaurant_category_settings_table', 42),
(146, '2022_10_17_131755_create_warranty_form_settings_table', 46),
(151, '2022_12_10_132825_create_rep_in_barcodes_table', 51),
(152, '2022_12_10_133045_create_rep_out_barcodes_table', 52),
(153, '2023_01_01_102347_create_replacement_form_settings_table', 53),
(154, '2023_01_09_095559_create_transection_terms_table', 54),
(155, '2023_01_29_125029_create_service_from_settings_table', 55),
(166, '2023_02_01_092341_create_individual_replace_form_settings_table', 66),
(167, '2023_02_01_225513_create_invoice_prefixes_table', 67),
(170, '2022_02_01_144650_create_product_price_lists_table', 68),
(171, '2022_10_17_110539_create_warranty_masters_table', 69),
(172, '2022_10_17_110733_create_warranty_details_table', 70),
(173, '2022_12_08_163116_create_replacement_masters_table', 71),
(174, '2022_12_08_163848_create_replacement_item_ins_table', 72),
(175, '2022_12_08_163918_create_replacement_item_outs_table', 73),
(176, '2022_12_08_163959_create_replacement_item_accounts_table', 74),
(177, '2023_01_29_125737_create_service_masters_table', 75),
(178, '2023_01_29_125802_create_service_details_table', 76),
(179, '2023_01_29_125821_create_service_accounts_table', 77),
(180, '2023_02_01_091907_create_individual_replace_masters_table', 78),
(181, '2023_02_01_091950_create_individual_replace_old_items_table', 79),
(182, '2023_02_01_092010_create_individual_replace_in_items_table', 80),
(183, '2023_02_01_092025_create_individual_replace_in_accounts_table', 81),
(184, '2023_02_01_092104_create_individual_replace_out_items_table', 82),
(185, '2023_02_01_092122_create_individual_replace_out_accounts_table', 83),
(186, '2022_10_17_131531_create_warranty_accounts_table', 84),
(187, '2023_05_05_011803_create_warrenty_dates_table', 85),
(188, '2023_06_18_100351_create_assign_leaves_table', 86),
(189, '2023_06_18_101023_create_hrm_attendances_table', 87),
(190, '2023_06_18_101432_create_hrm_departments_table', 88),
(191, '2023_06_18_101753_create_hrm_education_table', 89),
(192, '2023_06_18_102041_create_hrm_emergencies_table', 90),
(193, '2023_06_18_102300_create_hrm_empaddresses_table', 91),
(194, '2023_06_18_103221_create_hrm_experiences_table', 92),
(195, '2023_06_18_102513_create_hrm_employees_table', 93),
(196, '2023_06_18_104114_create_hrm_grades_table', 94),
(198, '2023_06_18_104829_create_hrm_holiday_details_table', 96),
(199, '2023_06_18_105101_create_hrm_holidays_table', 97),
(200, '2023_06_18_112430_create_hrm_itaxconfigs_table', 98),
(201, '2023_06_18_112556_create_hrm_itaxledgers_table', 99),
(202, '2023_06_18_112855_create_hrm_itaxpayables_table', 100),
(203, '2023_06_18_113018_create_hrm_itaxrebates_table', 101),
(204, '2023_06_18_113134_create_hrm_jobs_table', 102),
(205, '2023_06_18_113423_create_hrm_jobcontracts_table', 103),
(206, '2023_06_18_113641_create_hrm_jobtitles_table', 104),
(207, '2023_06_18_113754_create_hrm_languages_table', 105),
(208, '2023_06_18_113924_create_hrm_leavebalances_table', 106),
(209, '2023_06_18_114103_create_hrm_leaveentitlements_table', 107),
(210, '2023_06_18_114220_create_hrm_leavetypes_table', 108),
(211, '2023_06_18_115158_create_hrm_nominees_table', 109),
(212, '2023_06_18_115510_create_hrm_payheads_table', 110),
(213, '2023_06_18_115719_create_hrm_payinfos_table', 111),
(214, '2023_06_18_120001_create_hrm_payunits_table', 112),
(215, '2023_06_18_120059_create_hrm_profitcenters_table', 113),
(216, '2023_06_18_120152_create_hrm_recruitments_table', 114),
(217, '2023_06_18_120441_create_hrm_rewards_table', 115),
(218, '2023_06_18_120558_create_hrm_salarystructures_table', 116),
(219, '2023_06_18_120801_create_hrm_sstructuredetails_table', 117),
(220, '2023_06_18_120953_create_hrm_trainings_table', 118),
(221, '2023_06_18_121146_create_hrm_transfers_table', 119),
(222, '2023_06_18_121335_create_hrm_vacancies_table', 120),
(223, '2023_06_18_121545_create_hrm_weekworkdays_table', 121),
(224, '2023_06_18_104414_create_hrm_guarantors_table', 122),
(225, '2023_07_05_123626_create_companies_table', 123),
(230, '2023_10_03_160336_create_budgets_table', 124),
(231, '2023_10_03_164418_create_budget_details_table', 125),
(232, '2023_10_03_164912_create_budget_revisions_table', 126),
(233, '2023_10_03_164924_create_budget_revision_details_table', 127),
(234, '2023_10_04_161432_create_budget_item_details_table', 128),
(235, '2023_10_04_162838_create_budget_revision_item_details_table', 129),
(236, '2023_10_05_142342_create_audits_table', 130),
(237, '2023_10_09_111043_create_cost_center_authorised_chains_table', 131),
(238, '2023_10_09_152952_create_designations_table', 132),
(239, '2023_10_09_161140_create_hrm_emp_categories_table', 133),
(240, '2023_10_09_165711_create_hrm_emp_locations_table', 134),
(241, '2023_10_16_115059_create_material_issues_table', 135),
(242, '2023_10_16_115719_create_material_issue_details_table', 136),
(243, '2023_10_16_115808_create_material_issue_settings_table', 137),
(244, '2023_10_16_124956_create_material_issue_returns_table', 138),
(245, '2023_10_16_125030_create_material_issue_return_details_table', 139),
(246, '2023_10_16_125703_create_material_issue_return_settings_table', 140),
(247, '2023_10_16_100506_create_rlp_masters_table', 141),
(248, '2023_10_16_110209_create_rlp_details_table', 142),
(249, '2023_10_16_112015_create_rlp_remarks_table', 143),
(250, '2023_10_16_113111_create_rlp_acknowledgements_table', 144),
(251, '2023_10_16_114125_create_rlp_delete_histories_table', 145),
(252, '2023_10_16_114544_create_rlp_access_chains_table', 146),
(253, '2023_10_18_102437_create_material_issue_barcodes_table', 147),
(254, '2023_10_19_104029_create_material_issue_return_barcodes_table', 148),
(256, '2023_10_16_160436_create_access_chain_users_table', 149),
(257, '2023_10_22_101352_create_rlp_user_groups_table', 150),
(258, '2023_10_25_104956_create_rlp_account_details_table', 151),
(259, '2023_10_26_154216_create_status_details_table', 152),
(260, '2023_11_06_094606_create_import_puchases_table', 153),
(261, '2023_11_06_095029_create_import_puchase_details_table', 154),
(262, '2023_11_06_095044_create_import_puchase_accounts_table', 155),
(263, '2023_11_06_095205_create_import_puchase_barcodes_table', 156),
(264, '2023_11_06_095402_create_import_puchase_form_settings_table', 157),
(265, '2023_11_06_103037_create_setting_key_values_table', 158),
(266, '2023_11_06_103446_create_vessel_infos_table', 159),
(267, '2023_11_08_100253_create_org_branch_items_table', 160),
(268, '2023_11_12_110244_create_mother_vessels_table', 161),
(269, '2023_11_12_144640_create_import_receive_vessel_infos_table', 162),
(270, '2023_11_14_144059_create_vessel_routes_table', 163),
(271, '2023_11_16_015516_create_current_salary_structures_table', 164),
(272, '2023_11_16_170154_create_item_types_table', 165),
(273, '2023_11_18_132310_create_hrm_pay_head_types_table', 166),
(274, '2023_11_20_005408_create_current_salary_masters_table', 167),
(276, '2023_11_30_003629_create_hrm_monthly_salary_details_table', 169),
(277, '2023_11_30_003140_create_hrm_monthly_salary_masters_table', 170);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(1, 'App\\Models\\User', 46),
(1, 'App\\Models\\User', 51),
(1, 'App\\Models\\User', 57),
(3, 'App\\Models\\User', 47),
(3, 'App\\Models\\User', 49),
(3, 'App\\Models\\User', 53),
(3, 'App\\Models\\User', 58),
(3, 'App\\Models\\User', 61),
(3, 'App\\Models\\User', 62),
(3, 'App\\Models\\User', 67),
(3, 'App\\Models\\User', 69),
(5, 'App\\Models\\User', 4),
(5, 'App\\Models\\User', 5),
(5, 'App\\Models\\User', 28),
(5, 'App\\Models\\User', 31),
(5, 'App\\Models\\User', 33),
(5, 'App\\Models\\User', 34),
(5, 'App\\Models\\User', 35),
(5, 'App\\Models\\User', 36),
(5, 'App\\Models\\User', 38),
(5, 'App\\Models\\User', 40),
(5, 'App\\Models\\User', 54),
(5, 'App\\Models\\User', 55),
(6, 'App\\Models\\User', 56),
(6, 'App\\Models\\User', 68),
(10, 'App\\Models\\User', 52),
(10, 'App\\Models\\User', 63),
(10, 'App\\Models\\User', 64),
(10, 'App\\Models\\User', 65),
(10, 'App\\Models\\User', 66),
(10, 'App\\Models\\User', 72),
(10, 'App\\Models\\User', 73),
(10, 'App\\Models\\User', 74),
(10, 'App\\Models\\User', 75),
(10, 'App\\Models\\User', 76),
(10, 'App\\Models\\User', 77),
(10, 'App\\Models\\User', 78),
(10, 'App\\Models\\User', 79),
(10, 'App\\Models\\User', 80),
(10, 'App\\Models\\User', 81),
(10, 'App\\Models\\User', 82),
(10, 'App\\Models\\User', 83),
(10, 'App\\Models\\User', 84),
(10, 'App\\Models\\User', 85),
(10, 'App\\Models\\User', 86),
(10, 'App\\Models\\User', 87),
(10, 'App\\Models\\User', 88),
(10, 'App\\Models\\User', 89),
(10, 'App\\Models\\User', 90),
(10, 'App\\Models\\User', 91),
(10, 'App\\Models\\User', 92),
(10, 'App\\Models\\User', 93),
(10, 'App\\Models\\User', 94),
(10, 'App\\Models\\User', 95),
(10, 'App\\Models\\User', 96),
(10, 'App\\Models\\User', 97),
(10, 'App\\Models\\User', 98),
(10, 'App\\Models\\User', 99),
(10, 'App\\Models\\User', 100),
(10, 'App\\Models\\User', 101),
(10, 'App\\Models\\User', 102),
(10, 'App\\Models\\User', 103),
(10, 'App\\Models\\User', 104),
(10, 'App\\Models\\User', 105),
(10, 'App\\Models\\User', 106),
(10, 'App\\Models\\User', 107),
(10, 'App\\Models\\User', 108),
(10, 'App\\Models\\User', 109),
(10, 'App\\Models\\User', 110),
(10, 'App\\Models\\User', 111),
(10, 'App\\Models\\User', 112),
(10, 'App\\Models\\User', 113),
(10, 'App\\Models\\User', 114),
(10, 'App\\Models\\User', 115),
(10, 'App\\Models\\User', 116),
(10, 'App\\Models\\User', 117),
(10, 'App\\Models\\User', 118),
(10, 'App\\Models\\User', 119),
(10, 'App\\Models\\User', 120),
(10, 'App\\Models\\User', 121),
(10, 'App\\Models\\User', 122),
(10, 'App\\Models\\User', 123),
(10, 'App\\Models\\User', 124),
(10, 'App\\Models\\User', 125),
(10, 'App\\Models\\User', 126),
(10, 'App\\Models\\User', 127),
(10, 'App\\Models\\User', 128),
(10, 'App\\Models\\User', 129),
(10, 'App\\Models\\User', 130),
(10, 'App\\Models\\User', 131),
(10, 'App\\Models\\User', 132),
(10, 'App\\Models\\User', 133),
(10, 'App\\Models\\User', 134),
(10, 'App\\Models\\User', 135),
(10, 'App\\Models\\User', 136),
(10, 'App\\Models\\User', 137),
(10, 'App\\Models\\User', 138),
(10, 'App\\Models\\User', 139),
(10, 'App\\Models\\User', 140),
(10, 'App\\Models\\User', 141),
(10, 'App\\Models\\User', 142),
(10, 'App\\Models\\User', 143),
(10, 'App\\Models\\User', 144),
(10, 'App\\Models\\User', 145),
(10, 'App\\Models\\User', 146),
(10, 'App\\Models\\User', 147),
(10, 'App\\Models\\User', 148),
(10, 'App\\Models\\User', 149),
(10, 'App\\Models\\User', 150),
(10, 'App\\Models\\User', 151),
(10, 'App\\Models\\User', 152),
(10, 'App\\Models\\User', 153),
(10, 'App\\Models\\User', 154),
(10, 'App\\Models\\User', 155),
(10, 'App\\Models\\User', 156),
(10, 'App\\Models\\User', 157),
(10, 'App\\Models\\User', 158),
(10, 'App\\Models\\User', 159),
(10, 'App\\Models\\User', 160),
(10, 'App\\Models\\User', 161),
(10, 'App\\Models\\User', 162),
(10, 'App\\Models\\User', 163),
(10, 'App\\Models\\User', 164),
(10, 'App\\Models\\User', 165),
(10, 'App\\Models\\User', 166),
(10, 'App\\Models\\User', 167),
(10, 'App\\Models\\User', 168),
(10, 'App\\Models\\User', 169),
(10, 'App\\Models\\User', 170),
(10, 'App\\Models\\User', 171),
(10, 'App\\Models\\User', 172),
(10, 'App\\Models\\User', 173),
(10, 'App\\Models\\User', 174),
(10, 'App\\Models\\User', 175),
(10, 'App\\Models\\User', 176),
(10, 'App\\Models\\User', 177),
(10, 'App\\Models\\User', 178),
(10, 'App\\Models\\User', 179),
(10, 'App\\Models\\User', 180),
(10, 'App\\Models\\User', 181),
(10, 'App\\Models\\User', 182),
(10, 'App\\Models\\User', 183),
(10, 'App\\Models\\User', 184),
(10, 'App\\Models\\User', 185),
(10, 'App\\Models\\User', 186),
(10, 'App\\Models\\User', 187),
(10, 'App\\Models\\User', 188),
(10, 'App\\Models\\User', 189),
(10, 'App\\Models\\User', 190),
(10, 'App\\Models\\User', 191),
(10, 'App\\Models\\User', 192),
(10, 'App\\Models\\User', 193),
(10, 'App\\Models\\User', 194),
(10, 'App\\Models\\User', 195),
(10, 'App\\Models\\User', 196),
(10, 'App\\Models\\User', 197),
(10, 'App\\Models\\User', 198),
(10, 'App\\Models\\User', 199),
(10, 'App\\Models\\User', 200),
(10, 'App\\Models\\User', 201),
(10, 'App\\Models\\User', 202),
(10, 'App\\Models\\User', 203),
(10, 'App\\Models\\User', 204),
(10, 'App\\Models\\User', 205),
(10, 'App\\Models\\User', 206),
(10, 'App\\Models\\User', 207),
(10, 'App\\Models\\User', 208),
(10, 'App\\Models\\User', 209),
(10, 'App\\Models\\User', 210),
(10, 'App\\Models\\User', 211),
(10, 'App\\Models\\User', 212),
(10, 'App\\Models\\User', 213),
(10, 'App\\Models\\User', 214),
(10, 'App\\Models\\User', 215),
(10, 'App\\Models\\User', 216),
(10, 'App\\Models\\User', 217),
(10, 'App\\Models\\User', 218),
(10, 'App\\Models\\User', 219),
(10, 'App\\Models\\User', 220),
(10, 'App\\Models\\User', 221),
(10, 'App\\Models\\User', 222),
(10, 'App\\Models\\User', 223),
(10, 'App\\Models\\User', 224),
(10, 'App\\Models\\User', 225),
(10, 'App\\Models\\User', 226),
(10, 'App\\Models\\User', 227),
(10, 'App\\Models\\User', 228),
(10, 'App\\Models\\User', 229),
(10, 'App\\Models\\User', 230),
(10, 'App\\Models\\User', 231),
(10, 'App\\Models\\User', 232),
(10, 'App\\Models\\User', 233),
(10, 'App\\Models\\User', 234),
(10, 'App\\Models\\User', 235),
(10, 'App\\Models\\User', 236),
(10, 'App\\Models\\User', 237),
(10, 'App\\Models\\User', 238),
(10, 'App\\Models\\User', 239),
(10, 'App\\Models\\User', 240),
(10, 'App\\Models\\User', 241),
(10, 'App\\Models\\User', 242),
(10, 'App\\Models\\User', 243),
(10, 'App\\Models\\User', 244),
(10, 'App\\Models\\User', 245),
(10, 'App\\Models\\User', 246),
(10, 'App\\Models\\User', 247),
(10, 'App\\Models\\User', 248),
(10, 'App\\Models\\User', 249),
(10, 'App\\Models\\User', 250),
(10, 'App\\Models\\User', 251),
(10, 'App\\Models\\User', 252),
(10, 'App\\Models\\User', 253),
(10, 'App\\Models\\User', 254),
(10, 'App\\Models\\User', 255),
(10, 'App\\Models\\User', 256),
(10, 'App\\Models\\User', 257),
(10, 'App\\Models\\User', 258),
(10, 'App\\Models\\User', 259),
(10, 'App\\Models\\User', 260),
(10, 'App\\Models\\User', 261),
(10, 'App\\Models\\User', 262),
(10, 'App\\Models\\User', 263),
(10, 'App\\Models\\User', 264),
(10, 'App\\Models\\User', 265),
(10, 'App\\Models\\User', 266),
(10, 'App\\Models\\User', 267),
(10, 'App\\Models\\User', 268),
(10, 'App\\Models\\User', 269),
(10, 'App\\Models\\User', 270),
(10, 'App\\Models\\User', 271),
(10, 'App\\Models\\User', 272),
(10, 'App\\Models\\User', 273),
(10, 'App\\Models\\User', 274),
(10, 'App\\Models\\User', 275),
(10, 'App\\Models\\User', 276),
(10, 'App\\Models\\User', 277),
(10, 'App\\Models\\User', 278),
(10, 'App\\Models\\User', 279),
(10, 'App\\Models\\User', 280),
(10, 'App\\Models\\User', 281),
(10, 'App\\Models\\User', 282),
(10, 'App\\Models\\User', 283),
(10, 'App\\Models\\User', 284),
(10, 'App\\Models\\User', 285),
(10, 'App\\Models\\User', 286),
(10, 'App\\Models\\User', 287),
(10, 'App\\Models\\User', 288),
(10, 'App\\Models\\User', 289),
(10, 'App\\Models\\User', 290),
(10, 'App\\Models\\User', 291),
(10, 'App\\Models\\User', 292),
(10, 'App\\Models\\User', 293),
(10, 'App\\Models\\User', 294),
(10, 'App\\Models\\User', 295),
(10, 'App\\Models\\User', 296),
(10, 'App\\Models\\User', 297),
(10, 'App\\Models\\User', 298),
(10, 'App\\Models\\User', 299),
(10, 'App\\Models\\User', 300),
(10, 'App\\Models\\User', 301),
(10, 'App\\Models\\User', 302),
(10, 'App\\Models\\User', 303),
(10, 'App\\Models\\User', 304),
(10, 'App\\Models\\User', 305),
(10, 'App\\Models\\User', 306),
(10, 'App\\Models\\User', 307),
(10, 'App\\Models\\User', 308),
(10, 'App\\Models\\User', 309),
(10, 'App\\Models\\User', 310),
(10, 'App\\Models\\User', 311),
(10, 'App\\Models\\User', 312),
(10, 'App\\Models\\User', 313),
(10, 'App\\Models\\User', 314),
(10, 'App\\Models\\User', 315),
(10, 'App\\Models\\User', 316),
(10, 'App\\Models\\User', 317),
(10, 'App\\Models\\User', 318),
(10, 'App\\Models\\User', 319),
(10, 'App\\Models\\User', 320),
(10, 'App\\Models\\User', 321),
(10, 'App\\Models\\User', 322),
(10, 'App\\Models\\User', 323),
(10, 'App\\Models\\User', 324),
(10, 'App\\Models\\User', 325),
(10, 'App\\Models\\User', 326),
(10, 'App\\Models\\User', 327),
(10, 'App\\Models\\User', 328),
(10, 'App\\Models\\User', 329),
(10, 'App\\Models\\User', 330),
(10, 'App\\Models\\User', 331),
(10, 'App\\Models\\User', 332),
(10, 'App\\Models\\User', 333),
(10, 'App\\Models\\User', 334),
(10, 'App\\Models\\User', 335),
(10, 'App\\Models\\User', 336),
(10, 'App\\Models\\User', 337),
(10, 'App\\Models\\User', 338),
(10, 'App\\Models\\User', 339),
(10, 'App\\Models\\User', 340),
(10, 'App\\Models\\User', 341),
(10, 'App\\Models\\User', 342),
(10, 'App\\Models\\User', 343),
(10, 'App\\Models\\User', 344),
(10, 'App\\Models\\User', 345),
(10, 'App\\Models\\User', 346),
(10, 'App\\Models\\User', 347),
(10, 'App\\Models\\User', 348),
(10, 'App\\Models\\User', 349),
(10, 'App\\Models\\User', 350),
(10, 'App\\Models\\User', 351),
(10, 'App\\Models\\User', 352),
(10, 'App\\Models\\User', 353),
(10, 'App\\Models\\User', 354),
(10, 'App\\Models\\User', 355),
(10, 'App\\Models\\User', 356),
(10, 'App\\Models\\User', 357),
(10, 'App\\Models\\User', 358),
(10, 'App\\Models\\User', 359),
(10, 'App\\Models\\User', 360),
(10, 'App\\Models\\User', 361),
(10, 'App\\Models\\User', 362),
(10, 'App\\Models\\User', 363),
(10, 'App\\Models\\User', 364),
(10, 'App\\Models\\User', 365),
(10, 'App\\Models\\User', 366),
(10, 'App\\Models\\User', 367),
(10, 'App\\Models\\User', 368),
(10, 'App\\Models\\User', 369),
(10, 'App\\Models\\User', 370),
(10, 'App\\Models\\User', 371),
(10, 'App\\Models\\User', 372),
(10, 'App\\Models\\User', 373),
(10, 'App\\Models\\User', 374),
(10, 'App\\Models\\User', 375),
(10, 'App\\Models\\User', 376),
(10, 'App\\Models\\User', 377),
(10, 'App\\Models\\User', 378),
(10, 'App\\Models\\User', 379),
(10, 'App\\Models\\User', 380),
(10, 'App\\Models\\User', 381),
(10, 'App\\Models\\User', 382),
(10, 'App\\Models\\User', 383),
(10, 'App\\Models\\User', 384),
(10, 'App\\Models\\User', 385),
(10, 'App\\Models\\User', 386),
(10, 'App\\Models\\User', 387),
(10, 'App\\Models\\User', 388),
(10, 'App\\Models\\User', 389),
(10, 'App\\Models\\User', 390),
(10, 'App\\Models\\User', 391),
(10, 'App\\Models\\User', 392),
(10, 'App\\Models\\User', 393),
(10, 'App\\Models\\User', 394),
(10, 'App\\Models\\User', 395),
(10, 'App\\Models\\User', 396),
(10, 'App\\Models\\User', 397),
(10, 'App\\Models\\User', 398),
(10, 'App\\Models\\User', 399),
(10, 'App\\Models\\User', 400),
(10, 'App\\Models\\User', 401),
(10, 'App\\Models\\User', 402),
(10, 'App\\Models\\User', 403),
(10, 'App\\Models\\User', 404),
(10, 'App\\Models\\User', 405),
(10, 'App\\Models\\User', 406),
(10, 'App\\Models\\User', 407),
(10, 'App\\Models\\User', 408),
(10, 'App\\Models\\User', 409),
(10, 'App\\Models\\User', 410),
(10, 'App\\Models\\User', 411),
(10, 'App\\Models\\User', 412),
(10, 'App\\Models\\User', 413),
(10, 'App\\Models\\User', 414),
(10, 'App\\Models\\User', 415),
(10, 'App\\Models\\User', 416),
(10, 'App\\Models\\User', 417),
(10, 'App\\Models\\User', 418),
(10, 'App\\Models\\User', 419),
(10, 'App\\Models\\User', 420),
(10, 'App\\Models\\User', 421),
(10, 'App\\Models\\User', 422),
(10, 'App\\Models\\User', 423),
(10, 'App\\Models\\User', 424),
(10, 'App\\Models\\User', 425),
(10, 'App\\Models\\User', 426),
(10, 'App\\Models\\User', 427),
(10, 'App\\Models\\User', 428),
(10, 'App\\Models\\User', 429),
(10, 'App\\Models\\User', 430),
(10, 'App\\Models\\User', 431),
(10, 'App\\Models\\User', 432),
(10, 'App\\Models\\User', 433),
(10, 'App\\Models\\User', 434),
(10, 'App\\Models\\User', 435),
(10, 'App\\Models\\User', 436),
(10, 'App\\Models\\User', 437),
(10, 'App\\Models\\User', 438),
(10, 'App\\Models\\User', 439),
(10, 'App\\Models\\User', 440),
(10, 'App\\Models\\User', 441),
(10, 'App\\Models\\User', 442),
(10, 'App\\Models\\User', 443),
(10, 'App\\Models\\User', 444),
(10, 'App\\Models\\User', 445),
(10, 'App\\Models\\User', 446),
(10, 'App\\Models\\User', 447),
(10, 'App\\Models\\User', 448),
(10, 'App\\Models\\User', 449),
(10, 'App\\Models\\User', 450),
(10, 'App\\Models\\User', 451),
(10, 'App\\Models\\User', 452),
(10, 'App\\Models\\User', 453),
(10, 'App\\Models\\User', 454),
(10, 'App\\Models\\User', 455),
(10, 'App\\Models\\User', 456),
(10, 'App\\Models\\User', 457),
(10, 'App\\Models\\User', 458),
(10, 'App\\Models\\User', 459),
(10, 'App\\Models\\User', 460),
(10, 'App\\Models\\User', 461),
(10, 'App\\Models\\User', 462),
(10, 'App\\Models\\User', 463),
(10, 'App\\Models\\User', 464),
(10, 'App\\Models\\User', 465),
(10, 'App\\Models\\User', 466),
(10, 'App\\Models\\User', 467),
(10, 'App\\Models\\User', 468),
(10, 'App\\Models\\User', 469),
(10, 'App\\Models\\User', 470),
(10, 'App\\Models\\User', 471),
(10, 'App\\Models\\User', 472),
(10, 'App\\Models\\User', 473),
(10, 'App\\Models\\User', 474),
(10, 'App\\Models\\User', 475),
(10, 'App\\Models\\User', 476),
(10, 'App\\Models\\User', 477),
(10, 'App\\Models\\User', 478),
(10, 'App\\Models\\User', 479),
(10, 'App\\Models\\User', 480),
(10, 'App\\Models\\User', 481),
(10, 'App\\Models\\User', 482),
(10, 'App\\Models\\User', 483),
(10, 'App\\Models\\User', 484),
(10, 'App\\Models\\User', 485),
(10, 'App\\Models\\User', 486),
(10, 'App\\Models\\User', 487),
(10, 'App\\Models\\User', 488),
(10, 'App\\Models\\User', 489),
(10, 'App\\Models\\User', 490),
(10, 'App\\Models\\User', 491),
(10, 'App\\Models\\User', 492),
(10, 'App\\Models\\User', 493),
(10, 'App\\Models\\User', 494),
(10, 'App\\Models\\User', 495),
(10, 'App\\Models\\User', 496),
(10, 'App\\Models\\User', 497),
(10, 'App\\Models\\User', 498),
(10, 'App\\Models\\User', 499),
(10, 'App\\Models\\User', 500),
(10, 'App\\Models\\User', 501),
(10, 'App\\Models\\User', 502),
(10, 'App\\Models\\User', 503),
(10, 'App\\Models\\User', 504),
(10, 'App\\Models\\User', 505),
(10, 'App\\Models\\User', 506),
(10, 'App\\Models\\User', 507),
(10, 'App\\Models\\User', 508),
(10, 'App\\Models\\User', 509),
(10, 'App\\Models\\User', 510),
(10, 'App\\Models\\User', 511),
(10, 'App\\Models\\User', 512),
(10, 'App\\Models\\User', 513),
(10, 'App\\Models\\User', 514),
(10, 'App\\Models\\User', 515),
(10, 'App\\Models\\User', 516),
(11, 'App\\Models\\User', 59),
(11, 'App\\Models\\User', 70),
(12, 'App\\Models\\User', 71);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_sales_targets`
--

CREATE TABLE `monthly_sales_targets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_fescal_year` varchar(255) DEFAULT NULL,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_emp_table_id` int(11) NOT NULL DEFAULT 0,
  `_group` int(11) NOT NULL DEFAULT 0,
  `_year` int(11) NOT NULL DEFAULT 0,
  `_month_no` int(11) NOT NULL DEFAULT 0,
  `_period_start` date DEFAULT NULL,
  `_period_end` date DEFAULT NULL,
  `sales_commision_plans_id` int(11) NOT NULL DEFAULT 0,
  `_target_amount` double NOT NULL DEFAULT 0,
  `_sales_amount` double NOT NULL DEFAULT 0,
  `_sales_return_amount` double NOT NULL DEFAULT 0,
  `_collection_amount` double NOT NULL DEFAULT 0,
  `_is_sms` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mother_vessels`
--

CREATE TABLE `mother_vessels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_license_no` varchar(255) DEFAULT NULL,
  `_country_name` varchar(255) DEFAULT NULL,
  `_type` varchar(255) DEFAULT NULL COMMENT 'Local,foreign',
  `_route` varchar(255) DEFAULT NULL COMMENT 'Air,Sea,Road',
  `_owner_name` varchar(255) DEFAULT NULL,
  `_contact_one` varchar(255) DEFAULT NULL,
  `_contact_two` varchar(255) DEFAULT NULL,
  `_contact_three` varchar(255) DEFAULT NULL,
  `_capacity` double NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mother_vessels`
--

INSERT INTO `mother_vessels` (`id`, `_name`, `_code`, `_license_no`, `_country_name`, `_type`, `_route`, `_owner_name`, `_contact_one`, `_contact_two`, `_contact_three`, `_capacity`, `is_delete`, `_status`, `created_at`, `updated_at`) VALUES
(1, 'MV.JIN BI', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, 54000, 0, 1, '2023-11-12 09:19:32', '2023-11-12 09:19:32'),
(2, 'Vessel Two', NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, 56000, 0, 1, '2023-11-14 05:14:03', '2023-11-14 05:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `musak_four_point_threes`
--

CREATE TABLE `musak_four_point_threes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_first_delivery_date` date DEFAULT NULL,
  `_additional_vat_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cost_price` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_price` double(15,4) NOT NULL DEFAULT 0.0000,
  `_responsible_person` varchar(255) DEFAULT NULL,
  `_res_per_designation` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_gp_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_gp_per` double(15,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `musak_four_point_three_additions`
--

CREATE TABLE `musak_four_point_three_additions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_short_narr` varchar(200) DEFAULT NULL,
  `_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_last_edition` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `musak_four_point_three_inputs`
--

CREATE TABLE `musak_four_point_three_inputs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `conversion_qty` double(15,4) NOT NULL DEFAULT 1.0000,
  `_code` varchar(255) DEFAULT NULL,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_wastage_amt` double(15,4) NOT NULL DEFAULT 0.0000,
  `_wastage_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `_last_edition` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_unit_conversion` double(15,4) NOT NULL DEFAULT 0.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notesheets`
--

CREATE TABLE `notesheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notesheet_no` varchar(255) NOT NULL,
  `notesheet_id` int(11) NOT NULL DEFAULT 0,
  `rlp_no` varchar(255) NOT NULL,
  `rlp_id` int(11) NOT NULL DEFAULT 0,
  `item` int(11) NOT NULL DEFAULT 0,
  `item_name` varchar(255) NOT NULL,
  `unit` int(11) NOT NULL DEFAULT 0,
  `part_no` varchar(255) DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0,
  `remarks` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `_status` int(11) NOT NULL DEFAULT 0,
  `_lock` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notesheets_master`
--

CREATE TABLE `notesheets_master` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `notesheet_prefix` varchar(255) NOT NULL,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `request_project` int(11) NOT NULL DEFAULT 0,
  `request_warehouse` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `rlp_id` int(11) NOT NULL DEFAULT 0,
  `notesheet_no` varchar(255) DEFAULT NULL,
  `rlp_no` varchar(255) DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `ns_info` longtext DEFAULT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `supplier_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `concern_person` varchar(255) DEFAULT NULL,
  `cell_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_of_item` double NOT NULL DEFAULT 0,
  `sub_total` double NOT NULL DEFAULT 0,
  `ait_input` double NOT NULL DEFAULT 0,
  `total_ait` double NOT NULL DEFAULT 0,
  `vat_input` double NOT NULL DEFAULT 0,
  `total_vat` double NOT NULL DEFAULT 0,
  `_discount_input` double NOT NULL DEFAULT 0,
  `total_discount` double NOT NULL DEFAULT 0,
  `total_afterdiscount` double NOT NULL DEFAULT 0,
  `grand_total` double NOT NULL DEFAULT 0,
  `remarks` longtext DEFAULT NULL,
  `terms_condition` longtext DEFAULT NULL,
  `notesheet_status` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `is_wo` tinyint(4) NOT NULL DEFAULT 0,
  `attached_file` varchar(255) DEFAULT NULL,
  `is_viewed` tinyint(4) NOT NULL DEFAULT 0,
  `is_ns` tinyint(4) NOT NULL DEFAULT 0,
  `_status` int(11) NOT NULL DEFAULT 0,
  `_lock` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notesheet_account_details`
--

CREATE TABLE `notesheet_account_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ns_info_id` int(11) NOT NULL DEFAULT 0,
  `_ns_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_ns_ledger_description` varchar(255) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `_details_remarks` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notesheet_remarks_history`
--

CREATE TABLE `notesheet_remarks_history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notesheet_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `user_office_id` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `remarks_date` date DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_branches`
--

CREATE TABLE `organization_branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_branch_stores`
--

CREATE TABLE `organization_branch_stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_cost_centers`
--

CREATE TABLE `organization_cost_centers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `cost_center_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_departments`
--

CREATE TABLE `organization_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_department_designations`
--

CREATE TABLE `organization_department_designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) NOT NULL DEFAULT 0,
  `designation_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_designations`
--

CREATE TABLE `organization_designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `designation_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_stores`
--

CREATE TABLE `organization_stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `store_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `org_branch_items`
--

CREATE TABLE `org_branch_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL,
  `_branch_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_rows`
--

CREATE TABLE `page_rows` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `row_num` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_rows`
--

INSERT INTO `page_rows` (`id`, `row_num`, `created_at`, `updated_at`) VALUES
(1, 10, NULL, NULL),
(2, 20, NULL, NULL),
(3, 30, NULL, NULL),
(4, 40, NULL, NULL),
(5, 50, NULL, NULL),
(6, 60, NULL, NULL),
(7, 100, NULL, NULL),
(8, 200, NULL, NULL),
(9, 300, NULL, NULL),
(10, 500, NULL, NULL),
(11, 100, NULL, NULL),
(12, 2000, NULL, NULL),
(13, 5000, NULL, NULL),
(14, 10000, NULL, NULL),
(15, 20000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_receive_details`
--

CREATE TABLE `payment_receive_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_order_number` varchar(255) NOT NULL,
  `_table_name` varchar(255) NOT NULL,
  `_ref_id` int(11) NOT NULL DEFAULT 0,
  `_ref_order_number` varchar(255) DEFAULT NULL,
  `_p_d_able_amount` double NOT NULL DEFAULT 0,
  `_p_d_amount` double NOT NULL DEFAULT 0,
  `_rest_amount` double NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_receive_masters`
--

CREATE TABLE `payment_receive_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_defalut_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_note` varchar(255) DEFAULT NULL,
  `_document` varchar(255) DEFAULT NULL,
  `_voucher_type` varchar(255) DEFAULT NULL,
  `_transection_type` varchar(255) DEFAULT NULL,
  `_transection_for` varchar(255) DEFAULT NULL,
  `_transection_ref` varchar(255) DEFAULT NULL,
  `_form_name` varchar(255) DEFAULT NULL,
  `_bank_name` varchar(255) DEFAULT NULL,
  `_branch_name` varchar(255) DEFAULT NULL,
  `_bank_account` varchar(255) DEFAULT NULL,
  `_issue_date` varchar(255) DEFAULT NULL,
  `_cash_date` varchar(255) DEFAULT NULL,
  `_check_no` varchar(255) DEFAULT NULL,
  `_amount` double NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'admin',
  `module_name` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `type`, `module_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'role-list', 'web', 'Role', NULL, 1, NULL, NULL),
(2, 'role-create', 'web', 'Role', NULL, 1, NULL, NULL),
(3, 'role-edit', 'web', 'Role', NULL, 1, NULL, NULL),
(4, 'role-delete', 'web', 'Role', NULL, 1, NULL, NULL),
(5, 'user-list', 'web', 'User', NULL, 1, NULL, NULL),
(6, 'user-create', 'web', 'User', NULL, 1, NULL, NULL),
(7, 'user-edit', 'web', 'User', NULL, 1, NULL, NULL),
(8, 'user-delete', 'web', 'User', NULL, 1, NULL, NULL),
(9, 'account-type-list', 'web', 'Accounts', NULL, 1, NULL, NULL),
(10, 'account-type-create', 'web', 'Accounts', NULL, 1, NULL, NULL),
(11, 'account-type-edit', 'web', 'Accounts', NULL, 1, NULL, NULL),
(12, 'account-type-delete', 'web', 'Accounts', NULL, 1, NULL, NULL),
(13, 'account-group-list', 'web', 'Accounts', NULL, 1, NULL, NULL),
(14, 'account-group-create', 'web', 'Accounts', NULL, 1, NULL, NULL),
(15, 'account-group-edit', 'web', 'Accounts', NULL, 1, NULL, NULL),
(16, 'account-group-delete', 'web', 'Accounts', NULL, 1, NULL, NULL),
(17, 'branch-list', 'web', 'Branch', NULL, 1, NULL, NULL),
(18, 'branch-create', 'web', 'Branch', NULL, 1, NULL, NULL),
(19, 'branch-edit', 'web', 'Branch', NULL, 1, NULL, NULL),
(20, 'branch-delete', 'web', 'Branch', NULL, 1, NULL, NULL),
(21, 'cost-center-list', 'web', 'Cost Center', NULL, 1, NULL, NULL),
(22, 'cost-center-create', 'web', 'Cost Center', NULL, 1, NULL, NULL),
(23, 'cost-center-edit', 'web', 'Cost Center', NULL, 1, NULL, NULL),
(24, 'cost-center-delete', 'web', 'Cost Center', NULL, 1, NULL, NULL),
(25, 'store-house-list', 'web', 'Store', NULL, 1, NULL, NULL),
(26, 'store-house-create', 'web', 'Store', NULL, 1, NULL, NULL),
(27, 'store-house-edit', 'web', 'Store', NULL, 1, NULL, NULL),
(28, 'store-house-delete', 'web', 'Store', NULL, 1, NULL, NULL),
(30, 'account-ledger-list', 'web', 'Accounts', NULL, 1, NULL, NULL),
(31, 'account-ledger-create', 'web', 'Accounts', NULL, 1, NULL, NULL),
(32, 'account-ledger-edit', 'web', 'Accounts', NULL, 1, NULL, NULL),
(33, 'account-ledger-delete', 'web', 'Accounts', NULL, 1, NULL, NULL),
(34, 'voucher-list', 'web', 'Voucher', NULL, 1, NULL, NULL),
(35, 'voucher-create', 'web', 'Voucher', NULL, 1, NULL, NULL),
(36, 'voucher-edit', 'web', 'Voucher', NULL, 1, NULL, NULL),
(37, 'voucher-delete', 'web', 'Voucher', NULL, 1, NULL, NULL),
(38, 'voucher-print', 'web', 'Voucher', NULL, 1, NULL, NULL),
(39, 'ledger-report', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(40, 'trail-balance', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(41, 'income-statement', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(42, 'balance-sheet', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(43, 'work-sheet', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(44, 'group-ledger', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(45, 'account-report-menu', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(46, 'income-statement-settings', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(47, 'inventory-menu', 'web', 'Inventory', NULL, 1, NULL, NULL),
(48, 'item-category-list', 'web', 'Inventory', NULL, 1, NULL, NULL),
(49, 'item-category-create', 'web', 'Inventory', NULL, 1, NULL, NULL),
(50, 'item-category-edit', 'web', 'Inventory', NULL, 1, NULL, NULL),
(51, 'item-category-delete', 'web', 'Inventory', NULL, 1, NULL, NULL),
(52, 'item-information-list', 'web', 'Inventory', NULL, 1, NULL, NULL),
(53, 'item-information-create', 'web', 'Inventory', NULL, 1, NULL, NULL),
(54, 'item-information-edit', 'web', 'Inventory', NULL, 1, NULL, NULL),
(55, 'item-information-delete', 'web', 'Inventory', NULL, 1, NULL, NULL),
(56, 'purchase-list', 'web', 'Purchase', NULL, 1, NULL, NULL),
(57, 'purchase-create', 'web', 'Purchase', NULL, 1, NULL, NULL),
(58, 'purchase-edit', 'web', 'Purchase', NULL, 1, NULL, NULL),
(59, 'purchase-delete', 'web', 'Purchase', NULL, 1, NULL, NULL),
(60, 'unit-list', 'web', 'Inventory', NULL, 1, NULL, NULL),
(61, 'unit-create', 'web', 'Inventory', NULL, 1, NULL, NULL),
(62, 'unit-edit', 'web', 'Inventory', NULL, 1, NULL, NULL),
(63, 'unit-delete', 'web', 'Inventory', NULL, 1, NULL, NULL),
(64, 'purchase-print', 'web', 'Purchase', NULL, 1, NULL, NULL),
(65, 'purchase-form-settings', 'web', 'Purchase', NULL, 1, NULL, NULL),
(66, 'purchase-return-form-settings', 'web', 'Purchase Return', NULL, 1, NULL, NULL),
(67, 'purchase-return-print', 'web', 'Purchase Return', NULL, 1, NULL, NULL),
(68, 'purchase-return-delete', 'web', 'Purchase Return', NULL, 1, NULL, NULL),
(69, 'purchase-return-edit', 'web', 'Purchase Return', NULL, 1, NULL, NULL),
(70, 'purchase-return-create', 'web', 'Purchase Return', NULL, 1, NULL, NULL),
(71, 'purchase-return-list', 'web', 'Purchase Return', NULL, 1, NULL, NULL),
(72, 'sales-list', 'web', 'Sales', NULL, 1, NULL, NULL),
(73, 'sales-create', 'web', 'Sales', NULL, 1, NULL, NULL),
(74, 'sales-edit', 'web', 'Sales', NULL, 1, NULL, NULL),
(75, 'sales-delete', 'web', 'Sales', NULL, 0, NULL, NULL),
(76, 'sales-print', 'web', 'Sales', NULL, 1, NULL, NULL),
(77, 'sales-form-settings', 'web', 'Sales', NULL, 1, NULL, NULL),
(78, 'sales-return-list', 'web', 'Sales Return', NULL, 1, NULL, NULL),
(79, 'sales-return-create', 'web', 'Sales Return', NULL, 1, NULL, NULL),
(80, 'sales-return-edit', 'web', 'Sales Return', NULL, 1, NULL, NULL),
(81, 'sales-return-delete', 'web', 'Sales Return', NULL, 0, NULL, NULL),
(82, 'sales-return-print', 'web', 'Sales Return', NULL, 1, NULL, NULL),
(83, 'sales-return-settings', 'web', 'Sales Return', NULL, 1, NULL, NULL),
(84, 'lot-item-information', 'web', 'Inventory', NULL, 1, NULL, NULL),
(85, 'bill-party-statement', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(86, 'date-wise-purchase', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(87, 'purchase-summary-statement', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(88, 'purchase-return-detail', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(89, 'sales-summary-statement', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(90, 'date-wise-sales', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(91, 'sales-return-detail', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(92, 'stock-possition', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(93, 'stock-ledger', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(94, 'stock-value', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(95, 'stock-value-register', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(96, 'gross-profit', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(97, 'expired-item', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(98, 'inventory-report', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(99, 'purchase-order-print', 'web', 'Purchase Order', NULL, 1, NULL, NULL),
(100, 'purchase-order-delete', 'web', 'Purchase Order', NULL, 1, NULL, NULL),
(101, 'purchase-order-edit', 'web', 'Purchase Order', NULL, 1, NULL, NULL),
(102, 'purchase-order-create', 'web', 'Purchase Order', NULL, 1, NULL, NULL),
(103, 'purchase-order-list', 'web', 'Purchase Order', NULL, 1, NULL, NULL),
(104, 'shortage-item', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(105, 'damage-list', 'web', 'Damage Adjustment', NULL, 1, NULL, NULL),
(106, 'damage-create', 'web', 'Damage Adjustment', NULL, 1, NULL, NULL),
(107, 'damage-edit', 'web', 'Damage Adjustment', NULL, 1, NULL, NULL),
(108, 'damage-delete', 'web', 'Damage Adjustment', NULL, 1, NULL, NULL),
(109, 'damage-print', 'web', 'Damage Adjustment', NULL, 1, NULL, NULL),
(110, 'damage-form-settings', 'web', 'Damage Adjustment', NULL, 1, NULL, NULL),
(111, 'item-sales-price-update', 'web', 'Inventory', NULL, 1, NULL, NULL),
(112, 'money-receipt-print', 'web', 'Voucher', NULL, 1, NULL, NULL),
(113, 'lock-permission', 'web', 'General Settings', NULL, 1, NULL, NULL),
(114, 'admin-settings', 'web', 'General Settings', NULL, 1, NULL, NULL),
(115, 'admin-settings-store', 'web', 'General Settings', NULL, 1, NULL, NULL),
(116, 'purchase-return-lock', 'web', 'Purchase Return', NULL, 1, NULL, NULL),
(117, 'voucher-lock', 'web', 'Voucher', NULL, 1, NULL, NULL),
(118, 'quick-link', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(119, 'top-due-customer', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(120, 'top-payable-supplier', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(121, 'total-purchase', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(122, 'total-sales', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(123, 'total-purchase-return', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(124, 'total-sales-return', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(125, 'daily-sales-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(126, 'monthly-sales-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(127, 'daily-purchase-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(128, 'monthly-purchase-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(129, 'product-stock-alert', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(130, 'stock-expiry-alert', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(131, 'daily-sales-return-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(132, 'monthly-sales-return-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(133, 'monthly-purchase-return-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(134, 'daily-purchase-return-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(135, 'daily-damage-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(136, 'monthly-damage-chart', 'web', 'Dashboard', NULL, 1, NULL, NULL),
(137, 'money-payment-receipt', 'web', 'Voucher', NULL, 1, NULL, NULL),
(138, 'chart-of-account', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(139, 'warranty-list', 'web', 'Warranty', NULL, 1, NULL, NULL),
(140, 'warranty-create', 'web', 'Warranty', NULL, 1, NULL, NULL),
(141, 'warranty-edit', 'web', 'Warranty', NULL, 1, NULL, NULL),
(142, 'warranty-delete', 'web', 'Warranty', NULL, 1, NULL, NULL),
(143, 'ledger-summary-report', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(144, 'labels-print', 'web', 'Inventory', NULL, 1, NULL, NULL),
(145, 'barcode-history', 'web', 'Inventory', NULL, 1, NULL, NULL),
(146, 'user-wise-collection-report', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(147, 'user-wise-payment-report', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(148, 'account-menu', 'web', 'Accounts', NULL, 1, NULL, NULL),
(149, 'cash-receive', 'web', 'Accounts', NULL, 1, NULL, NULL),
(150, 'cash-payment', 'web', 'Accounts', NULL, 1, NULL, NULL),
(151, 'bank-payment', 'web', 'Accounts', NULL, 1, NULL, NULL),
(152, 'bank-receive', 'web', 'Accounts', NULL, 1, NULL, NULL),
(153, 'cash-book', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(154, 'bank-book', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(155, 'receipt-payment', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(156, 'user-wise-collection-payment', 'web', 'Advance Report', NULL, 1, NULL, NULL),
(157, 'sales-man-wise-sales', 'web', 'Advance Report', NULL, 1, NULL, NULL),
(158, 'delivery-man-sales', 'web', 'Advance Report', NULL, 1, NULL, NULL),
(159, 'delivery-man-sales-return', 'web', 'Advance Report', NULL, 1, NULL, NULL),
(160, 'sales-man-sales-return', 'web', 'Advance Report', NULL, 1, NULL, NULL),
(161, 'date-wise-invoice-print', 'web', 'Advance Report', NULL, 1, NULL, NULL),
(162, 'delivery-sales-invoice', 'web', 'Advance Report', NULL, 1, NULL, NULL),
(163, 'advance-report-menu', 'web', 'Advance Report', NULL, 1, NULL, NULL),
(164, 'day-book', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(165, 'transfer-list', 'web', 'Transfer', NULL, 1, NULL, NULL),
(166, 'transfer-create', 'web', 'Transfer', NULL, 1, NULL, NULL),
(167, 'transfer-edit', 'web', 'Transfer', NULL, 1, NULL, NULL),
(168, 'transfer-delete', 'web', 'Transfer', NULL, 1, NULL, NULL),
(169, 'production-settings', 'web', 'Production', NULL, 1, NULL, NULL),
(170, 'bulk-sms', 'web', 'General Settings', NULL, 1, NULL, NULL),
(171, 'sales-order-form-settings', 'web', 'Sales Order', NULL, 0, NULL, NULL),
(172, 'sales-order-print', 'web', 'Sales Order', NULL, 0, NULL, NULL),
(173, 'sales-order-delete', 'web', 'Sales Order', NULL, 0, NULL, NULL),
(174, 'sales-order-edit', 'web', 'Sales Order', NULL, 0, NULL, NULL),
(175, 'sales-order-create', 'web', 'Sales Order', NULL, 0, NULL, NULL),
(176, 'sales-order-list', 'web', 'Sales Order', NULL, 0, NULL, NULL),
(177, 'database-backup', 'web', 'General Settings', NULL, 1, NULL, NULL),
(178, 'production-list', 'web', 'Production', NULL, 1, NULL, NULL),
(179, 'production-create', 'web', 'Production', NULL, 1, NULL, NULL),
(180, 'production-edit', 'web', 'Production', NULL, 1, NULL, NULL),
(181, 'production-delete', 'web', 'Production', NULL, 1, NULL, NULL),
(182, 'transfer-settings', 'web', 'Transfer', NULL, 1, NULL, NULL),
(203, 'restaurant-pos', 'web', 'Restaurant POS', NULL, 1, NULL, NULL),
(204, 'vat-rules-list', 'web', 'Vat Rules', NULL, 1, NULL, NULL),
(205, 'vat-rules-create', 'web', 'Vat Rules', NULL, 1, NULL, NULL),
(206, 'vat-rules-edit', 'web', 'Vat Rules', NULL, 1, NULL, NULL),
(207, 'vat-rules-delete', 'web', 'Vat Rules', NULL, 1, NULL, NULL),
(228, 'day-wise-summary-report', 'web', 'Restaurant Report', NULL, 1, NULL, NULL),
(229, 'item-sales-report', 'web', 'Restaurant Report', NULL, 1, NULL, NULL),
(230, 'detail-item-sales-report', 'web', 'Restaurant Report', NULL, 1, NULL, NULL),
(257, 'invoice-prefix', 'web', 'General Settings', NULL, 1, NULL, NULL),
(258, 'warranty-check', 'web', 'Warranty Management', NULL, 1, NULL, NULL),
(259, 'easy-voucher-list', 'web', 'Voucher', NULL, 1, NULL, NULL),
(260, 'easy-voucher-create', 'web', 'Voucher', NULL, 1, NULL, NULL),
(261, 'easy-voucher-edit', 'web', 'Voucher', NULL, 1, NULL, NULL),
(262, 'easy-voucher-delete', 'web', 'Voucher', NULL, 0, NULL, NULL),
(263, 'inter-project-voucher-delete', 'web', 'Voucher', NULL, 0, NULL, NULL),
(264, 'inter-project-voucher-edit', 'web', 'Voucher', NULL, 1, NULL, NULL),
(265, 'inter-project-voucher-create', 'web', 'Voucher', NULL, 1, NULL, NULL),
(266, 'inter-project-voucher-list', 'web', 'Voucher', NULL, 1, NULL, NULL),
(267, 'actual-sales-report', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(293, 'hrm-module', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(294, 'week-work-day', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(295, 'holidays-list', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(296, 'holidays-create', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(297, 'holidays-edit', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(298, 'holidays-delete', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(299, 'leave-type-delete', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(300, 'leave-type-edit', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(301, 'leave-type-create', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(302, 'leave-type-list', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(303, 'pay-heads-delete', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(304, 'pay-heads-edit', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(305, 'pay-heads-create', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(306, 'pay-heads-list', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(307, 'companies-delete', 'web', 'Company', NULL, 1, NULL, NULL),
(308, 'companies-edit', 'web', 'Company', NULL, 1, NULL, NULL),
(309, 'companies-create', 'web', 'Company', NULL, 1, NULL, NULL),
(310, 'companies-list', 'web', 'Company', NULL, 1, NULL, NULL),
(311, 'hrm-department-delete', 'web', 'Department', NULL, 1, NULL, NULL),
(312, 'hrm-department-edit', 'web', 'Department', NULL, 1, NULL, NULL),
(313, 'hrm-department-create', 'web', 'Department', NULL, 1, NULL, NULL),
(314, 'hrm-department-list', 'web', 'Department', NULL, 1, NULL, NULL),
(315, 'hrm-grade-delete', 'web', 'HRM-Grade', NULL, 1, NULL, NULL),
(316, 'hrm-grade-edit', 'web', 'HRM-Grade', NULL, 1, NULL, NULL),
(317, 'hrm-grade-create', 'web', 'HRM-Grade', NULL, 1, NULL, NULL),
(318, 'hrm-grade-list', 'web', 'HRM-Grade', NULL, 1, NULL, NULL),
(319, 'budget-list', 'web', 'Budget', NULL, 1, NULL, NULL),
(320, 'budget-create', 'web', 'Budget', NULL, 1, NULL, NULL),
(321, 'budget-edit', 'web', 'Budget', NULL, 1, NULL, NULL),
(322, 'budget-delete', 'web', 'Budget', NULL, 1, NULL, NULL),
(323, 'budgets-list', 'web', 'Budgets', NULL, 1, NULL, NULL),
(324, 'budgets-create', 'web', 'Budgets', NULL, 1, NULL, NULL),
(325, 'budgets-edit', 'web', 'Budgets', NULL, 1, NULL, NULL),
(326, 'budgets-delete', 'web', 'Budgets', NULL, 1, NULL, NULL),
(327, 'cost-center-authorization-chain', 'web', 'Cost Center', NULL, 1, NULL, NULL),
(328, 'hrm-emp-category-list', 'web', 'Employee Category', NULL, 1, NULL, NULL),
(329, 'hrm-emp-category-create', 'web', 'Employee Category', NULL, 1, NULL, NULL),
(330, 'hrm-emp-category-edit', 'web', 'Employee Category', NULL, 1, NULL, NULL),
(331, 'hrm-emp-category-delete', 'web', 'Employee Category', NULL, 1, NULL, NULL),
(332, 'hrm-emp-location-list', 'web', 'Employee Location', NULL, 1, NULL, NULL),
(333, 'hrm-emp-location-create', 'web', 'Employee Location', NULL, 1, NULL, NULL),
(334, 'hrm-emp-location-edit', 'web', 'Employee Location', NULL, 1, NULL, NULL),
(335, 'hrm-emp-location-delete', 'web', 'Employee Location', NULL, 1, NULL, NULL),
(336, 'hrm-employee-list', 'web', 'Employee', NULL, 1, NULL, NULL),
(337, 'hrm-employee-create', 'web', 'Employee', NULL, 1, NULL, NULL),
(338, 'hrm-employee-edit', 'web', 'Employee', NULL, 1, NULL, NULL),
(339, 'hrm-employee-delete', 'web', 'Employee', NULL, 1, NULL, NULL),
(340, 'hrm-designation-list', 'web', 'Designation', NULL, 1, NULL, NULL),
(341, 'hrm-designation-create', 'web', 'Designation', NULL, 1, NULL, NULL),
(342, 'hrm-designation-edit', 'web', 'Designation', NULL, 1, NULL, NULL),
(343, 'hrm-designation-delete', 'web', 'Designation', NULL, 1, NULL, NULL),
(344, 'budget-compare', 'web', 'Budget', NULL, 1, NULL, NULL),
(345, 'material-issue-list', 'web', 'Material Issue', NULL, 1, NULL, NULL),
(346, 'material-issue-create', 'web', 'Material Issue', NULL, 1, NULL, NULL),
(347, 'material-issue-edit', 'web', 'Material Issue', NULL, 1, NULL, NULL),
(348, 'material-issue-delete', 'web', 'Material Issue', NULL, 1, NULL, NULL),
(349, 'material-issue-return-list', 'web', 'Issued Material Return', NULL, 1, NULL, NULL),
(350, 'material-issue-return-create', 'web', 'Issued Material Return', NULL, 1, NULL, NULL),
(351, 'material-issue-return-edit', 'web', 'Issued Material Return', NULL, 1, NULL, NULL),
(352, 'material-issue-return-delete', 'web', 'Issued Material Return', NULL, 1, NULL, NULL),
(353, 'material-issue-form-settings', 'web', 'Material Issue', NULL, 1, NULL, NULL),
(354, 'material-issue-return-print', 'web', 'Issued Material Return', NULL, 1, NULL, NULL),
(355, 'approval-chain-list', 'web', 'RLP Chain', 'RLP Module', 1, NULL, NULL),
(356, 'approval-chain-create', 'web', 'RLP Chain', 'RLP Module', 1, NULL, NULL),
(357, 'approval-chain-edit', 'web', 'RLP Chain', 'RLP Module', 1, NULL, NULL),
(358, 'approval-chain-delete', 'web', 'RLP Chain', 'RLP Module', 1, NULL, NULL),
(359, 'rlp-module', 'web', 'RLP', 'RLP Module', 1, NULL, NULL),
(360, 'rlp-delete', 'web', 'RLP', 'RLP Module', 1, NULL, NULL),
(361, 'rlp-edit', 'web', 'RLP', 'RLP Module', 1, NULL, NULL),
(362, 'rlp-create', 'web', 'RLP', 'RLP Module', 1, NULL, NULL),
(363, 'rlp-list', 'web', 'RLP', 'RLP Module', 1, NULL, NULL),
(364, 'user-profile-update', 'web', 'General Settings', 'General Settings', 1, NULL, NULL),
(365, 'notesheet-list', 'web', 'Notesheet', 'Procurement', 1, NULL, NULL),
(366, 'notesheet-create', 'web', 'Notesheet', 'Procurement', 1, NULL, NULL),
(367, 'notesheet-edit', 'web', 'Notesheet', 'Procurement', 1, NULL, NULL),
(368, 'notesheet-delete', 'web', 'Notesheet', 'Procurement', 1, NULL, NULL),
(369, 'rlp-to-notesheet', 'web', 'Notesheet', 'Procurement', 1, NULL, NULL),
(370, 'import-purchase-list', 'web', 'import Purchase', 'Procurement', 0, NULL, NULL),
(371, 'import-purchase-create', 'web', 'Import Purchase', 'Procurement', 0, NULL, NULL),
(372, 'import-purchase-edit', 'web', 'Import Purchase', 'Procurement', 0, NULL, NULL),
(373, 'import-purchase-delete', 'web', 'Import Purchase', 'Procurement', 0, NULL, NULL),
(374, 'import-purchase-print', 'web', 'Import Purchase', 'Procurement', 0, NULL, NULL),
(375, 'purchase-form-settings', 'web', 'Purchase', NULL, 1, NULL, NULL),
(376, 'vessel-info-list', 'web', 'Vessel', 'Procurement', 0, NULL, NULL),
(377, 'vessel-info-create', 'web', 'Vessel', 'Procurement', 0, NULL, NULL),
(378, 'vessel-info-edit', 'web', 'Vessel', 'Procurement', 0, NULL, NULL),
(379, 'vessel-info-delete', 'web', 'Vessel', 'Procurement', 0, NULL, NULL),
(380, 'mother-vessel-info-list', 'web', 'Vessel', 'Procurement', 0, NULL, NULL),
(381, 'mother-vessel-info-create', 'web', 'Vessel', 'Procurement', 0, NULL, NULL),
(382, 'mother-vessel-info-edit', 'web', 'Vessel', 'Procurement', 0, NULL, NULL),
(383, 'mother-vessel-info-delete', 'web', 'Vessel', 'Procurement', 0, NULL, NULL),
(384, 'import-material-receive-list', 'web', 'import Purchase', 'Procurement', 0, NULL, NULL),
(385, 'import-material-receive-create', 'web', 'Import Purchase', 'Procurement', 0, NULL, NULL),
(386, 'import-material-receive-edit', 'web', 'Import Purchase', 'Procurement', 0, NULL, NULL),
(387, 'import-material-receive-delete', 'web', 'Import Purchase', 'Procurement', 0, NULL, NULL),
(388, 'import-material-receive-print', 'web', 'Import Purchase', 'Procurement', 0, NULL, NULL),
(389, 'item-type-list', 'web', 'Inventory', NULL, 1, NULL, NULL),
(390, 'item-type-create', 'web', 'Inventory', NULL, 1, NULL, NULL),
(391, 'item-type-edit', 'web', 'Inventory', NULL, 1, NULL, NULL),
(392, 'item-type-delete', 'web', 'Inventory', NULL, 1, NULL, NULL),
(393, 'initial-salary-structure-list', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(394, 'initial-salary-structure-create', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(395, 'initial-salary-structure-edit', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(396, 'initial-salary-structure-delete', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(397, 'hrm-attandance-delete', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(398, 'hrm-attandance-edit', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(399, 'hrm-attandance-create', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(400, 'hrm-attandance-list', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(401, 'monthly-salary-structure-delete', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(402, 'monthly-salary-structure-edit', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(403, 'monthly-salary-structure-create', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(404, 'monthly-salary-structure-list', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(405, 'documents-list', 'web', 'Documents', 'Documents', 1, NULL, NULL),
(406, 'documents-create', 'web', 'Documents', 'Documents', 1, NULL, NULL),
(407, 'documents-edit', 'web', 'Documents', 'Documents', 1, NULL, NULL),
(408, 'documents-delete', 'web', 'Documents', 'Documents', 1, NULL, NULL),
(409, 'restaurant-module', 'web', 'Module', NULL, 0, NULL, NULL),
(410, 'restaurant-sales-create', 'web', 'Restaurant POS', NULL, 0, NULL, NULL),
(411, 'restaurant-sales-edit', 'web', 'Restaurant POS', NULL, 0, NULL, NULL),
(412, 'restaurant-sales-delete', 'web', 'Restaurant POS', NULL, 0, NULL, NULL),
(413, 'restaurant-sales-list', 'web', 'Restaurant POS', NULL, 0, NULL, NULL),
(414, 'table-info-list', 'web', 'Restaurant Table', NULL, 0, NULL, NULL),
(415, 'table-info-delete', 'web', 'Restaurant Table', NULL, 0, NULL, NULL),
(416, 'table-info-edit', 'web', 'Restaurant Table', NULL, 0, NULL, NULL),
(417, 'table-info-create', 'web', 'Restaurant Table', NULL, 0, NULL, NULL),
(418, 'table-info-menu', 'web', 'Restaurant Table', NULL, 0, NULL, NULL),
(419, 'kitchen-menu', 'web', 'Restaurant Kitchen', NULL, 0, NULL, NULL),
(420, 'kitchen-create', 'web', 'Restaurant Kitchen', NULL, 0, NULL, NULL),
(421, 'kitchen-edit', 'web', 'Restaurant Kitchen', NULL, 0, NULL, NULL),
(422, 'kitchen-delete', 'web', 'Restaurant Kitchen', NULL, 0, NULL, NULL),
(423, 'kitchen-list', 'web', 'Restaurant Kitchen', NULL, 0, NULL, NULL),
(424, 'musak-four-point-three-menu', 'web', 'Restaurant Mushak 4.3', NULL, 0, NULL, NULL),
(425, 'musak-four-point-three-create', 'web', 'Restaurant Mushak 4.3', NULL, 0, NULL, NULL),
(426, 'musak-four-point-three-edit', 'web', 'Restaurant Mushak 4.3', NULL, 0, NULL, NULL),
(427, 'musak-four-point-three-delete', 'web', 'Restaurant Mushak 4.3', NULL, 0, NULL, NULL),
(428, 'musak-four-point-three-list', 'web', 'Restaurant Mushak 4.3', NULL, 0, NULL, NULL),
(429, 'petty-cash', 'web', 'Accounts', NULL, 1, NULL, NULL),
(430, 'stock-balance', 'web', 'Inventory Report', NULL, 1, NULL, NULL),
(431, 'restaurant-sales-form-settings', 'web', 'Restaurant POS', NULL, 0, NULL, NULL),
(432, 'category-wise-item-list', 'web', 'Accounts Report', NULL, 1, NULL, NULL),
(433, 'partical-production-receive', 'web', 'Production', NULL, 0, NULL, NULL),
(434, 'finished_goods_receive_to_stock', 'web', 'Production', NULL, 0, NULL, NULL),
(435, 'production-print', 'web', 'Production', NULL, 0, NULL, NULL),
(436, 'partical-production-receive-edit', 'web', 'Production', NULL, 0, NULL, NULL),
(437, 'opening-inventory-entry', 'web', 'Purchase', NULL, 1, NULL, NULL),
(438, 'pack-size-list', 'web', 'Pack Size', NULL, 1, NULL, NULL),
(439, 'pack-size-create', 'web', 'Pack Size', NULL, 1, NULL, NULL),
(440, 'pack-size-edit', 'web', 'Pack Size', NULL, 1, NULL, NULL),
(441, 'pack-size-delete', 'web', 'Pack Size', NULL, 1, NULL, NULL),
(442, 'item-brand-list', 'web', 'Item Brand', NULL, 1, NULL, NULL),
(443, 'item-brand-create', 'web', 'Item Brand', NULL, 1, NULL, NULL),
(444, 'item-brand-edit', 'web', 'Item Brand', NULL, 1, NULL, NULL),
(445, 'item-brand-delete', 'web', 'Item Brand', NULL, 1, NULL, NULL),
(446, 'item-brand-print', 'web', 'Item Brand', NULL, 1, NULL, NULL),
(447, 'quaterly_insentive_setups-list', 'web', 'Incentive', 'Incentive', 0, NULL, NULL),
(448, 'quaterly_insentive_setups-create', 'web', 'Incentive', 'Incentive', 0, NULL, NULL),
(449, 'quaterly_insentive_setups-edit', 'web', 'Incentive', 'Incentive', 0, NULL, NULL),
(450, 'quaterly_insentive_setups-delete', 'web', 'Incentive', 'Incentive', 0, NULL, NULL),
(451, 'monthly_sales_targets-list', 'web', 'Sales', 'Sales Traget', 0, NULL, NULL),
(452, 'monthly_sales_targets-create', 'web', 'Sales', 'Sales Target', 0, NULL, NULL),
(453, 'monthly_sales_targets-edit', 'web', 'Sales', 'Sales Target', 0, NULL, NULL),
(454, 'monthly_sales_targets-delete', 'web', 'Sales', 'Sales Target', 0, NULL, NULL),
(455, 'monthly_sales_targets-show', 'web', 'Sales', 'Sales Traget', 0, NULL, NULL),
(456, 'item_bonus_setups-show', 'web', 'Sales', 'Bonus/Free Item', 0, NULL, NULL),
(457, 'item_bonus_setups-delete', 'web', 'Sales', 'Bonus/Free Item', 0, NULL, NULL),
(458, 'item_bonus_setups-edit', 'web', 'Sales', 'Bonus/Free Item', 0, NULL, NULL),
(459, 'item_bonus_setups-create', 'web', 'Sales', 'Bonus/Free Item', 0, NULL, NULL),
(460, 'item_bonus_setups-list', 'web', 'Sales', 'Bonus/Free Item', 0, NULL, NULL),
(461, 'zones-list', 'web', 'zones', 'zones', 1, NULL, NULL),
(462, 'zones-create', 'web', 'zones', 'zones', 1, NULL, NULL),
(463, 'zones-edit', 'web', 'zones', 'zones', 1, NULL, NULL),
(464, 'zones-delete', 'web', 'zones', 'zones', 1, NULL, NULL),
(465, 'damage_receive-list', 'web', 'Damage Receive', 'Damage Receive', 0, NULL, NULL),
(466, 'damage_receive-create', 'web', 'Damage Receive', 'Damage Receive', 0, NULL, NULL),
(467, 'damage_receive-edit', 'web', 'Damage Receive', 'Damage Receive', 0, NULL, NULL),
(468, 'damage_receive-delete', 'web', 'Damage Receive', 'Damage Receive', 0, NULL, NULL),
(469, 'damage_receive-print', 'web', 'Damage Receive', 'Damage Receive', 0, NULL, NULL),
(470, 'damage_send-print', 'web', 'Damage Send', 'Damage Send', 0, NULL, NULL),
(471, 'damage_send-delete', 'web', 'Damage Send', 'Damage Send', 0, NULL, NULL),
(472, 'damage_send-edit', 'web', 'Damage Send', 'Damage Send', 0, NULL, NULL),
(473, 'damage_send-create', 'web', 'Damage Send', 'Damage Send', 0, NULL, NULL),
(474, 'damage_send-list', 'web', 'Damage Send', 'Damage Send', 0, NULL, NULL),
(475, 'account_group_configs', 'web', 'General Settings', 'General Settings', 1, NULL, NULL),
(476, 'transection_terms-list', 'web', 'Transection Terms', 'Transection Terms', 1, NULL, NULL),
(477, 'transection_terms-create', 'web', 'Transection Terms', 'Transection Terms', 1, NULL, NULL),
(478, 'transection_terms-edit', 'web', 'Transection Terms', 'Transection Terms', 1, NULL, NULL),
(479, 'transection_terms-delete', 'web', 'Transection Terms', 'Transection Terms', 1, NULL, NULL),
(480, 'advance_income_statement', 'web', 'Accounts Report', 'Income Statement', 1, NULL, NULL),
(481, 'customer_due_statement', 'web', 'Accounts Report', 'Customer Due Statement', 1, NULL, NULL),
(482, 'sales_collection_report', 'web', 'Accounts Report', 'Sales Collection Report', 1, NULL, NULL),
(483, 'sales_man_wise_sales_detail', 'web', 'Inventory Report', 'Inventory Report', 1, NULL, NULL),
(484, 'branch_wise_sales_statement', 'web', 'Inventory Report', 'Inventory Report', 1, NULL, NULL),
(485, 'order_to_sales_invoice', 'web', 'Sales Order', 'Sales Order', 0, NULL, NULL),
(486, 'avaiable_product_list', 'web', 'Sales Order', 'Sales Order', 0, NULL, NULL),
(487, 'DM_module', 'web', 'Module', 'Damage Management', 0, NULL, NULL),
(488, 'damage_report', 'web', 'Damage Management', 'Damage Management', 0, NULL, NULL),
(489, 'dm_send_to_supplier', 'web', 'Damage Management', 'Damage Management', 0, NULL, NULL),
(490, 'dm_receive_from_stock', 'web', 'Damage Management', 'Damage Management', 0, NULL, NULL),
(491, 'dm_receive_from_customer', 'web', 'Damage Management', 'Damage Management', 0, NULL, NULL),
(492, 'dm_item_stock_value', 'web', 'Damage Management', 'Damage Management', 0, NULL, NULL),
(493, 'dm_item_stock_possition', 'web', 'Damage Management', 'Damage Management', 0, NULL, NULL),
(494, 'dm_item_ledger', 'web', 'Damage Management', 'Damage Management', 0, NULL, NULL),
(495, 'asset-category-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(496, 'asset-category-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(497, 'asset-category-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(498, 'asset-category-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(499, 'asset-condition-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(500, 'asset-condition-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(501, 'asset-condition-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(502, 'asset-condition-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(503, 'asset-location-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(504, 'asset-location-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(505, 'asset-location-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(506, 'asset-location-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(507, 'asset-actual-location-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(508, 'asset-actual-location-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(509, 'asset-actual-location-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(510, 'asset-actual-location-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(511, 'asset-vendor-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(512, 'asset-vendor-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(513, 'asset-vendor-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(514, 'asset-vendor-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(515, 'asset-users-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(516, 'asset-users-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(517, 'asset-users-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(518, 'asset-users-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(519, 'old-data-import-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(520, 'old-data-import-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(521, 'old-data-import-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(522, 'old-data-import-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(523, 'asset-entry-assign-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(524, 'asset-entry-assign-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(525, 'asset-entry-assign-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(526, 'asset-entry-assign-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(527, 'asset-brand-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(528, 'asset-brand-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(529, 'asset-brand-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(530, 'asset-brand-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(531, 'inspection-check-category-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(532, 'inspection-check-category-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(533, 'inspection-check-category-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(534, 'inspection-check-category-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(535, 'inspection-check-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(536, 'inspection-check-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(537, 'inspection-check-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(538, 'inspection-check-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(539, 'assign-status-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(540, 'assign-status-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(541, 'assign-status-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(542, 'assign-status-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(543, 'asset-management-report', 'web', 'Asset Management Report', 'Asset Management Report', 0, NULL, NULL),
(544, 'departments-list', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(545, 'departments-create', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(546, 'departments-edit', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(547, 'departments-delete', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(548, 'organizations-list', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(549, 'organizations-create', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(550, 'organizations-edit', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(551, 'organizations-delete', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(552, 'designations-list', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(553, 'designations-create', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(554, 'designations-edit', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(555, 'designations-delete', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(556, 'branches-list', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(557, 'branches-create', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(558, 'branches-edit', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(559, 'branches-delete', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(560, 'cost-centers-list', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(561, 'cost-centers-create', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(562, 'cost-centers-edit', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(563, 'cost-centers-delete', 'web', 'Basic', 'Basic', 1, NULL, NULL),
(564, 'asset_depreciation-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(565, 'asset_depreciation-create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(566, 'asset_depreciation-edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(567, 'asset_depreciation-delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(568, 'asset_sales_create', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(569, 'asset_sales_list', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(570, 'asset_sales_edit', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(571, 'asset_sales_delete', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(572, 'asset_disposal_delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(573, 'asset_disposal_edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(574, 'asset_disposal_list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(575, 'asset_disposal_create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(576, 'asset_import_cost_create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(577, 'asset_import_cost_list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(578, 'asset_import_cost_edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(579, 'asset_import_cost_delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(580, 'asset_maintainces_create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(581, 'asset_maintainces_list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(582, 'asset_maintainces_edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(583, 'asset_maintainces_delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(584, 'asset_eng_consumptions_create', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(585, 'asset_eng_consumptions_list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(586, 'asset_eng_consumptions_edit', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(587, 'asset_eng_consumptions_delete', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(588, 'item_rate_history', 'web', 'Inventory', 'Inventory', 1, NULL, NULL),
(589, 'sales-without-lot', 'web', 'Sales Without Lot', 'Sales Without Lot', 0, NULL, NULL),
(590, 'sales-without-lot', 'web', 'Sales Without Lot', 'Sales Without Lot', 0, NULL, NULL),
(591, 'online-invoice-send', 'web', 'Sales Without Lot', 'Sales Without Lot', 0, NULL, NULL),
(592, 'sales-list-wl', 'web', 'Sales Without Lot', 'Sales Without Lot', 0, NULL, NULL),
(593, 'sales-edit-wl', 'web', 'Sales Without Lot', 'Sales Without Lot', 0, NULL, NULL),
(594, 'sales-create-wl', 'web', 'Sales Without Lot', 'Sales Without Lot', 0, NULL, NULL),
(595, 'sales-print-wl', 'web', 'Sales Without Lot', 'Sales Without Lot', 0, NULL, NULL),
(596, 'sales_return_wlm-list', 'web', 'Sales Return WLM', NULL, 0, NULL, NULL),
(597, 'sales_return_wlm-create', 'web', 'Sales Return WLM', NULL, 0, NULL, NULL),
(598, 'sales_return_wlm-edit', 'web', 'Sales Return WLM', NULL, 0, NULL, NULL),
(599, 'sales_return_wlm-delete', 'web', 'Sales Return WLM', NULL, 0, NULL, NULL),
(600, 'sales_return_wlm-print', 'web', 'Sales Return WLM', NULL, 0, NULL, NULL),
(601, 'security_deposits-list', 'web', 'Security Deposits', 'Security Deposits', 0, NULL, NULL),
(602, 'security_deposits-create', 'web', 'Security Deposits', 'Security Deposits', 0, NULL, NULL),
(603, 'security_deposits-edit', 'web', 'Security Deposits', 'Security Deposits', 0, NULL, NULL),
(604, 'security_deposits-delete', 'web', 'Security Deposits', 'Security Deposits', 0, NULL, NULL),
(605, 'lc_manage-delete', 'web', 'Import', 'Import', 0, NULL, NULL),
(606, 'lc_manage-edit', 'web', 'Import', 'Import', 0, NULL, NULL),
(607, 'lc_manage-create', 'web', 'Import', 'Import', 0, NULL, NULL),
(608, 'lc_manage-list', 'web', 'Import', 'Import', 0, NULL, NULL),
(609, 'import_module', 'web', 'Module', 'Import', 0, NULL, NULL),
(610, 'asset_maintainces-list', 'web', 'Asset Management', 'Asset Management', 0, NULL, NULL),
(611, 'salary_sheet', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(612, 'salary_sheet_list', 'web', 'HRM', 'HRM', 1, NULL, NULL),
(613, 'transection_terms_wise_sales', 'web', 'Sales And Distributor Report', 'Sales And Distributor Report', 1, '2025-01-20 19:12:41', NULL),
(614, 'previous_sales_return-list', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(615, 'previous_sales_return-create', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(616, 'previous_sales_return-edit', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(617, 'previous_sales_return-delete', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(618, 'previous_sales_return-print', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(619, 'previous_sales_return-form-settings', 'web', 'Basic Inventory', 'Basic Inventory', 1, NULL, NULL),
(620, 'sales_officer_report', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(621, 'date_to_date_sales_amount_report', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(622, 'date_to_date_sales_item_report', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(623, 'date_to_date_sales_customer_report', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(624, 'date_to_date_due_customer_report', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(625, 'customer_list_report', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(626, 'date_to_date_net_sales_report', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(627, 'date_to_date_order_sales_report', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(628, 'date_to_date_sales_commission_report', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(629, 'sales_offer_list', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(630, 'payable_receivalbe_report', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(631, 'supplier_payment_list', 'web', 'supplier_payment', 'supplier_payment', 0, NULL, NULL),
(632, 'supplier_payment_create', 'web', 'supplier_payment', 'supplier_payment', 0, NULL, NULL),
(633, 'supplier_payment_edit', 'web', 'supplier_payment', 'supplier_payment', 0, NULL, NULL),
(634, 'supplier_payment_delete', 'web', 'supplier_payment', 'supplier_payment', 0, NULL, NULL),
(635, 'customer_payment_list', 'web', 'customer_payment', 'customer_payment', 0, NULL, NULL),
(636, 'customer_payment_create', 'web', 'customer_payment', 'customer_payment', 0, NULL, NULL),
(637, 'customer_payment_edit', 'web', 'customer_payment', 'customer_payment', 0, NULL, NULL),
(638, 'customer_payment_delete', 'web', 'customer_payment', 'customer_payment', 0, NULL, NULL),
(639, 'supplier_payment_print', 'web', 'customer_payment', 'customer_payment', 0, NULL, NULL),
(640, ' pos-sales-list', 'web', 'Sales', 'Sales', 0, NULL, NULL),
(641, 'customer_payment_print', 'web', 'customer_payment', 'customer_payment', 0, NULL, NULL),
(642, 'outstanding_detail_report', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(643, 'restaurant-report-menu', 'web', 'Module', 'Module', 0, NULL, NULL),
(644, 'transection_terms_wise_sales_report', 'web', 'Inventory Report', 'Inventory Report', 1, NULL, NULL),
(645, 'steward-waiter-menu', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(646, 'steward-waiter-list', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(647, 'steward-waiter-create', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(648, 'steward-waiter-edit', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(649, 'steward-waiter-delete', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(650, 'category-allocation-menu', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(651, 'category-allocation-list', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(652, 'category-allocation-create', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(653, 'category-allocation-edit', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(654, 'category-allocation-delete', 'web', 'Restaurant', 'Restaurant', 0, NULL, NULL),
(655, 'so_wise_due_invoice', 'web', 'Sales', 'Sales', 0, NULL, NULL),
(656, 'daily_dashboard', 'web', 'Dashboard', 'Dashboard', 0, NULL, NULL),
(657, 'final_due_statement', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(658, 'customer_statement', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(659, 'single_customer_statement', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(660, 'ledger_report_foreign', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(661, 'group_sub_group_summary_report', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(662, 'voucher-history', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(663, 'chart-of-ledger', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(664, 'advance_balance_sheet', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(665, 'general_balance-sheet', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(666, 'dashboard_sales_order', 'web', 'Dashboard', 'Dashboard', 0, NULL, NULL),
(667, 'dashboard_sales', 'web', 'Dashboard', 'Dashboard', 0, NULL, NULL),
(668, 'dashboard_sales_return', 'web', 'Dashboard', 'Dashboard', 0, NULL, NULL),
(669, 'dashboard_purchase_return', 'web', 'Dashboard', 'Dashboard', 0, NULL, NULL),
(670, 'dashboard_purchase', 'web', 'Dashboard', 'Dashboard', 0, NULL, NULL),
(671, 'dashboard_purchase_order', 'web', 'Dashboard', 'Dashboard', 0, NULL, NULL),
(672, 'dashboard_collection', 'web', 'Dashboard', 'Dashboard', 0, NULL, NULL),
(673, 'dashboard_payment', 'web', 'Dashboard', 'Dashboard', 0, NULL, NULL),
(674, 'dashboard_cash_possition', 'web', 'Dashboard', 'Dashboard', 1, NULL, NULL),
(675, 'dashboard_bank_possition', 'web', 'Dashboard', 'Dashboard', 1, NULL, NULL),
(676, 'branch_wise_item_sales_return_summary', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(677, 'branch_wise_item_sales_return_details', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(678, 'branch_and_customer_wise_s_r', 'web', 'Sales Officer Report', 'Sales Officer Report', 0, NULL, NULL),
(679, 'sales_commision_plans-list', 'web', 'sales_commision_plans', 'sales_commision_plans', 0, NULL, NULL),
(680, 'sales_commision_plans-create', 'web', 'sales_commision_plans', 'sales_commision_plans', 0, NULL, NULL),
(681, 'sales_commision_plans-edit', 'web', 'sales_commision_plans', 'sales_commision_plans', 0, NULL, NULL),
(682, 'sales_commision_plans-delete', 'web', 'sales_commision_plans', 'sales_commision_plans', 0, NULL, NULL),
(683, 'sales_commision_plans-print', 'web', 'sales_commision_plans', 'sales_commision_plans', 0, NULL, NULL),
(684, 'customer_sales_target_create', 'web', 'Customer Sales Target', 'Customer Sales Target', 0, NULL, NULL),
(685, 'customer_sales_target_list', 'web', 'Customer Sales Target', 'Customer Sales Target', 0, NULL, NULL),
(686, 'customer_sales_target_edit', 'web', 'Customer Sales Target', 'Customer Sales Target', 0, NULL, NULL),
(687, 'customer_sales_target_delete', 'web', 'Customer Sales Target', 'Customer Sales Target', 0, NULL, NULL),
(688, 'customer_sales_target_show', 'web', 'Customer Sales Target', 'Customer Sales Target', 0, NULL, NULL),
(689, 'ta_da_setups-delete', 'web', 'ta_da_setups', 'ta_da_setups', 1, NULL, NULL),
(690, 'ta_da_setups-edit', 'web', 'ta_da_setups', 'ta_da_setups', 1, NULL, NULL),
(691, 'ta_da_setups-create', 'web', 'ta_da_setups', 'ta_da_setups', 1, NULL, NULL),
(692, 'ta_da_setups-list', 'web', 'ta_da_setups', 'ta_da_setups', 1, NULL, NULL),
(693, 'cat_wise_ta_bills-list', 'web', 'cat_wise_ta_bills', 'cat_wise_ta_bills', 0, NULL, NULL),
(694, 'cat_wise_ta_bills-create', 'web', 'cat_wise_ta_bills', 'cat_wise_ta_bills', 0, NULL, NULL),
(695, 'cat_wise_ta_bills-edit', 'web', 'cat_wise_ta_bills', 'cat_wise_ta_bills', 0, NULL, NULL),
(696, 'cat_wise_ta_bills-delete', 'web', 'cat_wise_ta_bills', 'cat_wise_ta_bills', 0, NULL, NULL),
(697, 'employee_duty-delete', 'web', 'employee_duty', 'employee_duty', 0, NULL, NULL),
(698, 'employee_duty-edit', 'web', 'employee_duty', 'employee_duty', 0, NULL, NULL),
(699, 'employee_duty-create', 'web', 'employee_duty', 'employee_duty', 0, NULL, NULL),
(700, 'employee_duty-list', 'web', 'employee_duty', 'employee_duty', 0, NULL, NULL),
(701, 'customer_list', 'web', 'Accounts', 'Accounts', 1, NULL, NULL),
(702, 'cylindar_location-list', 'web', 'cylindar_location', 'cylindar_location', 0, NULL, NULL),
(703, 'cylindar_location-create', 'web', 'cylindar_location', 'cylindar_location', 0, NULL, NULL),
(704, 'cylindar_location-edit', 'web', 'cylindar_location', 'cylindar_location', 0, NULL, NULL),
(705, 'cylindar_location-delete', 'web', 'cylindar_location', 'cylindar_location', 0, NULL, NULL),
(706, 'cylindar_location', 'web', 'cylindar_location', 'cylindar_location', 0, NULL, NULL),
(707, 'sales_without_stock_deduct', 'web', 'Sales', 'Sales', 0, NULL, NULL),
(708, 'previous_bill_item_send', 'web', 'Sales', 'Sales', 0, NULL, NULL),
(709, 'month_wise_sallary_sheet', 'web', 'Hrm Report', 'Hrm Report', 1, NULL, NULL),
(710, 'stm_divisions_list', 'web', 'stm_divisions', 'stm_divisions', 1, NULL, NULL),
(711, 'stm_divisions_create', 'web', 'stm_divisions', 'stm_divisions', 1, NULL, NULL),
(712, 'stm_divisions_edit', 'web', 'stm_divisions', 'stm_divisions', 1, NULL, NULL),
(713, 'stm_divisions_delete', 'web', 'stm_divisions', 'stm_divisions', 1, NULL, NULL),
(714, 'stm_classes_list', 'web', 'stm_classes', 'stm_classes', 1, NULL, NULL),
(715, 'stm_classes_create', 'web', 'stm_classes', 'stm_classes', 1, NULL, NULL),
(716, 'stm_classes_edit', 'web', 'stm_classes', 'stm_classes', 1, NULL, NULL),
(717, 'stm_classes_delete', 'web', 'stm_classes', 'stm_classes', 1, NULL, NULL),
(718, 'stm_students_list', 'web', 'stm_students', 'stm_students', 1, NULL, NULL),
(719, 'stm_students_create', 'web', 'stm_students', 'stm_students', 1, NULL, NULL),
(720, 'stm_students_edit', 'web', 'stm_students', 'stm_students', 1, NULL, NULL),
(721, 'stm_students_delete', 'web', 'stm_students', 'stm_students', 1, NULL, NULL),
(722, 'stm_division_class_students_list', 'web', 'stm_division_class_students', 'stm_division_class_students', 1, NULL, NULL),
(723, 'stm_division_class_students_create', 'web', 'stm_division_class_students', 'stm_division_class_students', 1, NULL, NULL),
(724, 'stm_division_class_students_edit', 'web', 'stm_division_class_students', 'stm_division_class_students', 1, NULL, NULL),
(725, 'stm_division_class_students_delete', 'web', 'stm_division_class_students', 'stm_division_class_students', 1, NULL, NULL),
(726, 'stm_bill_masters_list', 'web', 'stm_bill_masters', 'stm_bill_masters', 1, NULL, NULL),
(727, 'stm_bill_masters_create', 'web', 'stm_bill_masters', 'stm_bill_masters', 1, NULL, NULL),
(728, 'stm_bill_masters_edit', 'web', 'stm_bill_masters', 'stm_bill_masters', 1, NULL, NULL),
(729, 'stm_bill_masters_delete', 'web', 'stm_bill_masters', 'stm_bill_masters', 1, NULL, NULL),
(730, 'stm_collection_masters_list', 'web', 'stm_collection_masters', 'stm_collection_masters', 1, NULL, NULL);
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `type`, `module_name`, `status`, `created_at`, `updated_at`) VALUES
(731, 'stm_collection_masters_create', 'web', 'stm_collection_masters', 'stm_collection_masters', 1, NULL, NULL),
(732, 'stm_collection_masters_edit', 'web', 'stm_collection_masters', 'stm_collection_masters', 1, NULL, NULL),
(733, 'stm_collection_masters_delete', 'web', 'stm_collection_masters', 'stm_collection_masters', 1, NULL, NULL),
(734, 'stm_education_sessions_list', 'web', 'stm_education_sessions', 'stm_education_sessions', 1, NULL, NULL),
(735, 'stm_education_sessions_create', 'web', 'stm_education_sessions', 'stm_education_sessions', 1, NULL, NULL),
(736, 'stm_education_sessions_edit', 'web', 'stm_education_sessions', 'stm_education_sessions', 1, NULL, NULL),
(737, 'stm_education_sessions_delete', 'web', 'stm_education_sessions', 'stm_education_sessions', 1, NULL, NULL),
(738, 'student_management', 'web', 'Module', 'Module', 1, NULL, NULL),
(739, 'countries_delete', 'web', 'countries', 'countries', 1, NULL, NULL),
(740, 'countries_edit', 'web', 'countries', 'countries', 1, NULL, NULL),
(741, 'countries_create', 'web', 'countries', 'countries', 1, NULL, NULL),
(742, 'countries_list', 'web', 'countries', 'countries', 1, NULL, NULL),
(743, 'stm_subjects_list', 'web', 'stm_subjects', 'stm_subjects', 1, NULL, NULL),
(744, 'stm_subjects_create', 'web', 'stm_subjects', 'stm_subjects', 1, NULL, NULL),
(745, 'stm_subjects_edit', 'web', 'stm_subjects', 'stm_subjects', 1, NULL, NULL),
(746, 'stm_subjects_delete', 'web', 'stm_subjects', 'stm_subjects', 1, NULL, NULL),
(747, 'group_wise_ledger_list', 'web', 'Accounts Report', 'Accounts Report', 1, NULL, NULL),
(748, 'honorim_setups_delete', 'web', 'honorim_setups', 'honorim_setups', 0, NULL, NULL),
(749, 'honorim_setups_edit', 'web', 'honorim_setups', 'honorim_setups', 0, NULL, NULL),
(750, 'honorim_setups_create', 'web', 'honorim_setups', 'honorim_setups', 0, NULL, NULL),
(751, 'honorim_setups_list', 'web', 'honorim_setups', 'honorim_setups', 0, NULL, NULL),
(752, 'honorarium_module', 'web', 'Module', 'Module', 0, NULL, NULL),
(753, 'honorarium_bills_list', 'web', 'honorarium_bills', 'honorarium_bills', 0, NULL, NULL),
(754, 'honorarium_bills_create', 'web', 'honorarium_bills', 'honorarium_bills', 0, NULL, NULL),
(755, 'honorarium_bills_edit', 'web', 'honorarium_bills', 'honorarium_bills', 0, NULL, NULL),
(756, 'honorarium_bills_delete', 'web', 'honorarium_bills', 'honorarium_bills', 0, NULL, NULL),
(757, 'honorarium_report', 'web', 'honorarium_bills', 'honorarium_bills', 0, NULL, NULL),
(758, 'honorarium_bill_sheet', 'web', 'honorarium_bills', 'honorarium_bills', 0, NULL, NULL),
(759, 'honorarium_payments_delete', 'web', 'honorarium_payments', 'honorarium_payments', 0, NULL, NULL),
(760, 'honorarium_payments_edit', 'web', 'honorarium_payments', 'honorarium_payments', 0, NULL, NULL),
(761, 'honorarium_payments_create', 'web', 'honorarium_payments', 'honorarium_payments', 0, NULL, NULL),
(762, 'honorarium_payments_list', 'web', 'honorarium_payments', 'honorarium_payments', 0, NULL, NULL),
(763, 'stm_division_class_students', 'web', 'stm_division_class_students', 'stm_division_class_students', 1, NULL, NULL),
(764, 'stm_income_ledger_setups', 'web', 'stm_division_class_students', 'stm_division_class_students', 1, NULL, NULL),
(765, 'admission_fee_collection', 'web', 'stm_division_class_students', 'stm_division_class_students', 1, NULL, NULL),
(766, 'admission_fee_collection_edit', 'web', 'stm_division_class_students', 'stm_division_class_students', 1, NULL, NULL),
(767, 'admission_fee_collection_delete', 'web', 'stm_division_class_students', 'stm_division_class_students', 1, NULL, NULL),
(768, 'stm_collection_delete', 'web', 'stm_collection', 'stm_collection', 1, NULL, NULL),
(769, 'stm_collection_edit', 'web', 'stm_collection', 'stm_collection', 1, NULL, NULL),
(770, 'stm_collection_create', 'web', 'stm_collection', 'stm_collection', 1, NULL, NULL),
(771, 'stm_collection_list', 'web', 'stm_collection', 'stm_collection', 1, NULL, NULL),
(772, 'division_class_student_report', 'web', 'stm_report_section', 'stm_report_section', 1, NULL, NULL),
(773, 'division_class_collection_report', 'web', 'stm_report_section', 'stm_report_section', 1, NULL, NULL),
(774, 'division_class_collection_status_report', 'web', 'stm_report_section', 'stm_report_section', 1, NULL, NULL),
(775, 'student_ledger_report', 'web', 'stm_report_section', 'stm_report_section', 1, NULL, NULL),
(776, 'month_wise_payment_status_report', 'web', 'stm_report_section', 'stm_report_section', 1, NULL, NULL),
(777, 'stm_report_section', 'web', 'stm_report_section', 'stm_report_section', 1, NULL, NULL),
(778, 'monthly_fee_collection_ledger', 'web', 'stm_report_section', 'stm_report_section', 1, NULL, NULL),
(779, 'stm_dashboard', 'web', 'stm_dashboard', 'stm_dashboard', 1, NULL, NULL),
(780, 'stmd_student_count', 'web', 'stm_dashboard', 'stm_dashboard', 1, NULL, NULL),
(781, 'stmd_today_collection_expense', 'web', 'stm_dashboard', 'stm_dashboard', 1, NULL, NULL),
(782, 'stmd_30_days_income_barchart', 'web', 'stm_dashboard', 'stm_dashboard', 1, NULL, NULL),
(783, 'stmd_30_days_expense_barchart', 'web', 'stm_dashboard', 'stm_dashboard', 1, NULL, NULL),
(784, 'stmd_monthly_income_expense_compare', 'web', 'stm_dashboard', 'stm_dashboard', 1, NULL, NULL),
(785, 'stmd_attandance_list', 'web', 'stm_dashboard', 'stm_dashboard', 1, NULL, NULL),
(786, 'stmd_absent_student_number', 'web', 'stm_dashboard', 'stm_dashboard', 1, NULL, NULL),
(787, 'stmd_today_absent_student_list', 'web', 'stm_dashboard', 'stm_dashboard', 1, NULL, NULL),
(788, 'collection_expense_report', 'web', 'stm_report_section', 'stm_report_section', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `postcodes`
--

CREATE TABLE `postcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` int(11) NOT NULL DEFAULT 0,
  `district_id` int(11) NOT NULL DEFAULT 0,
  `upazila` varchar(255) DEFAULT NULL,
  `postOffice` varchar(200) DEFAULT NULL,
  `postCode` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `priorities`
--

CREATE TABLE `priorities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `bg_color` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `priorities`
--

INSERT INTO `priorities` (`id`, `name`, `bg_color`, `created_at`, `updated_at`) VALUES
(1, 'Urgent', '#fff', NULL, NULL),
(2, 'High', '#fff', NULL, NULL),
(3, 'Medium', '#fff', NULL, NULL),
(4, 'Normal', '#fff', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `productions`
--

CREATE TABLE `productions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_invoice_number` varchar(150) DEFAULT NULL,
  `_date` date NOT NULL,
  `_from_organization_id` int(11) NOT NULL DEFAULT 1,
  `_to_organization_id` int(11) NOT NULL DEFAULT 1,
  `_from_cost_center` int(11) NOT NULL,
  `_from_branch` int(11) NOT NULL,
  `_to_cost_center` int(11) NOT NULL,
  `_to_branch` int(11) NOT NULL,
  `_reference` varchar(255) DEFAULT NULL,
  `_vessel_no` int(11) NOT NULL DEFAULT 0,
  `_arrival_date_time` datetime DEFAULT NULL,
  `_discharge_date_time` datetime DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_type` varchar(255) DEFAULT NULL,
  `_total` int(11) NOT NULL DEFAULT 0,
  `_stock_in__total` int(11) NOT NULL DEFAULT 0,
  `_p_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `_status` int(11) NOT NULL DEFAULT 0,
  `_lock` int(11) NOT NULL DEFAULT 0,
  `_loding_point` varchar(255) DEFAULT NULL,
  `_unloading_point` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_created_by` varchar(50) DEFAULT NULL,
  `_updated_by` varchar(50) DEFAULT NULL,
  `_order_number` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productions`
--

INSERT INTO `productions` (`id`, `_invoice_number`, `_date`, `_from_organization_id`, `_to_organization_id`, `_from_cost_center`, `_from_branch`, `_to_cost_center`, `_to_branch`, `_reference`, `_vessel_no`, `_arrival_date_time`, `_discharge_date_time`, `_note`, `_type`, `_total`, `_stock_in__total`, `_p_status`, `_status`, `_lock`, `_loding_point`, `_unloading_point`, `created_at`, `updated_at`, `_created_by`, `_updated_by`, `_order_number`) VALUES
(1, NULL, '2024-04-24', 1, 1, 26, 1, 26, 1, NULL, 0, NULL, NULL, 'Make for Project', 'production', 8530, 0, '3', 1, 0, NULL, NULL, '2024-04-24 08:24:16', '2024-04-24 08:24:16', '46-Admin', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `production_from_settings`
--

CREATE TABLE `production_from_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL,
  `_production_account` int(11) NOT NULL,
  `_transit_account` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_cost_rate` int(11) NOT NULL,
  `_show_sales_rate` tinyint(4) NOT NULL DEFAULT 0,
  `_show_vn` tinyint(4) NOT NULL DEFAULT 0,
  `_show_ard` tinyint(4) NOT NULL DEFAULT 0,
  `_show_disd` tinyint(4) NOT NULL DEFAULT 0,
  `_show_loding_point` tinyint(4) NOT NULL DEFAULT 0,
  `_show_unloading_point` tinyint(4) NOT NULL DEFAULT 0,
  `_show_warranty` int(11) NOT NULL,
  `_show_expire_date` int(11) NOT NULL,
  `_show_manufacture_date` int(11) NOT NULL,
  `_invoice_template` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_from_settings`
--

INSERT INTO `production_from_settings` (`id`, `_default_inventory`, `_production_account`, `_transit_account`, `_show_barcode`, `_show_store`, `_show_self`, `_show_unit`, `_show_cost_rate`, `_show_sales_rate`, `_show_vn`, `_show_ard`, `_show_disd`, `_show_loding_point`, `_show_unloading_point`, `_show_warranty`, `_show_expire_date`, `_show_manufacture_date`, `_invoice_template`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '2022-07-28 05:16:16', '2023-11-12 06:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `production_partial_receives`
--

CREATE TABLE `production_partial_receives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date NOT NULL,
  `_order_number` varchar(100) DEFAULT NULL,
  `_production_id` int(11) NOT NULL DEFAULT 0,
  `_production_order_number` varchar(255) DEFAULT NULL,
  `_start_date` date DEFAULT NULL,
  `_end_date` date DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_note` varchar(255) DEFAULT NULL,
  `_type` varchar(255) DEFAULT NULL,
  `_stock_in__total` double NOT NULL DEFAULT 0,
  `_p_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_status`
--

CREATE TABLE `production_status` (
  `id` int(11) NOT NULL,
  `_name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_status`
--

INSERT INTO `production_status` (`id`, `_name`, `created_at`, `updated_at`) VALUES
(1, 'Transit', '2022-07-18 22:02:08', NULL),
(2, 'Work-in-progress', '2022-07-18 22:02:08', NULL),
(3, 'Complete', '2022-07-18 22:02:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_incentive_earns`
--

CREATE TABLE `product_incentive_earns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_rate` double NOT NULL DEFAULT 0,
  `_value` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_price_lists`
--

CREATE TABLE `product_price_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_item` varchar(255) DEFAULT NULL,
  `_input_type` varchar(255) DEFAULT 'purchase',
  `_barcode` longtext DEFAULT NULL,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_pur_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_discount` varchar(50) NOT NULL DEFAULT '0' COMMENT 'use % if or it will be amount',
  `_sales_vat` varchar(50) NOT NULL DEFAULT '0' COMMENT 'use % if or it will be amount',
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `_p_discount_input` int(11) NOT NULL DEFAULT 0,
  `_p_discount_amount` int(11) NOT NULL DEFAULT 0,
  `_p_vat` int(11) NOT NULL DEFAULT 0,
  `_p_vat_amount` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 1,
  `_cost_center_id` int(11) NOT NULL DEFAULT 1,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_master_id` int(11) NOT NULL DEFAULT 0,
  `_order_number` varchar(200) DEFAULT NULL,
  `_store_salves_id` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_unique_barcode` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_category_id` int(11) NOT NULL DEFAULT 0,
  `_brand_id` int(11) NOT NULL DEFAULT 0,
  `_pack_size_id` int(11) NOT NULL DEFAULT 0,
  `is_lebel_print` tinyint(4) NOT NULL DEFAULT 0,
  `_receive_type` int(11) NOT NULL DEFAULT 0,
  `_table_name` varchar(255) DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_item_category` varchar(100) DEFAULT NULL,
  `_transfer_to_asset` tinyint(4) NOT NULL DEFAULT 0,
  `_short_note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proforma_sales`
--

CREATE TABLE `proforma_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_online_inv_no` varchar(150) DEFAULT NULL,
  `_payment_terms` int(11) NOT NULL DEFAULT 0,
  `payment_date` date DEFAULT NULL,
  `track_no` varchar(150) DEFAULT NULL,
  `driver_name` varchar(150) DEFAULT NULL,
  `driver_mob_no` varchar(100) DEFAULT NULL,
  `_delivery_details` text DEFAULT NULL,
  `_address` varchar(150) DEFAULT NULL,
  `_phone` varchar(50) DEFAULT NULL,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_trans_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(100) DEFAULT NULL,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(50) DEFAULT NULL,
  `_lock` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proforma_sales_details`
--

CREATE TABLE `proforma_sales_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_show_invoice` tinyint(4) NOT NULL DEFAULT 0,
  `_showing_item_name` text DEFAULT NULL,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_barcode` longtext DEFAULT NULL,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_management`
--

CREATE TABLE `project_management` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `project_address` text DEFAULT NULL,
  `project_image` text DEFAULT NULL,
  `project_cost` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_purchase_type` int(250) NOT NULL DEFAULT 0,
  `_po_number` varchar(250) DEFAULT NULL,
  `_rlp_no` varchar(250) DEFAULT NULL,
  `_note_sheet_no` varchar(250) DEFAULT NULL,
  `_workorder_no` varchar(250) DEFAULT NULL,
  `_lc_no` varchar(250) DEFAULT NULL,
  `import_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_vessel_no` varchar(200) DEFAULT NULL,
  `_capacity` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vessel_res_person` varchar(200) DEFAULT NULL,
  `_vessel_res_mobile` varchar(100) DEFAULT NULL,
  `_arrival_date_time` datetime DEFAULT NULL,
  `_loading_date_time` datetime DEFAULT NULL,
  `_discharge_date_time` datetime DEFAULT NULL,
  `_total_sd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_sd_per` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_sd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_cd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_cd_per` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_cd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_ait_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_ait_per` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_ait_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_rd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_rd_per` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_rd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_at_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_at_per` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_at_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_tti_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_tti_per` double(15,4) NOT NULL DEFAULT 0.0000,
  `_inv_tti_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_add_to_stock` tinyint(4) NOT NULL DEFAULT 0,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_address` varchar(100) DEFAULT NULL,
  `_phone` varchar(100) DEFAULT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_expected_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 1,
  `_store_id` int(11) NOT NULL DEFAULT 1,
  `_loding_point` varchar(255) DEFAULT NULL,
  `_unloading_point` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_direct_sales` tinyint(4) NOT NULL DEFAULT 0,
  `_direct_sales_no` varchar(200) DEFAULT NULL,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_paid_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_other_adjustment` double(15,4) NOT NULL DEFAULT 0.0000,
  `_due_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_trans_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_receive_type` tinyint(4) NOT NULL DEFAULT 0,
  `_delivery_status` tinyint(4) NOT NULL DEFAULT 0,
  `_receive_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_accounts`
--

CREATE TABLE `purchase_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_barcodes`
--

CREATE TABLE `purchase_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_expected_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_barcode` longtext DEFAULT NULL,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_short_note` varchar(200) DEFAULT NULL,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_ait` double(15,4) NOT NULL DEFAULT 0.0000,
  `_ait_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_at` double(15,4) NOT NULL DEFAULT 0.0000,
  `_at_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_tti` double(15,4) NOT NULL DEFAULT 0.0000,
  `_tti_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_form_settings`
--

CREATE TABLE `purchase_form_settings` (
  `id` int(11) NOT NULL,
  `_default_inventory` int(11) NOT NULL,
  `_default_purchase` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL,
  `_opening_inventory` int(11) NOT NULL DEFAULT 0,
  `_default_capital` int(11) NOT NULL DEFAULT 0,
  `_show_barcode` int(11) NOT NULL,
  `_show_short_note` tinyint(4) NOT NULL DEFAULT 0,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_vat` int(11) NOT NULL,
  `_inline_discount` tinyint(4) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `_show_manufacture_date` int(11) NOT NULL DEFAULT 0,
  `_show_expire_date` int(11) NOT NULL DEFAULT 0,
  `_invoice_template` int(11) NOT NULL DEFAULT 0,
  `_show_p_balance` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `_is_header` tinyint(4) NOT NULL DEFAULT 0,
  `_is_footer` tinyint(4) NOT NULL DEFAULT 0,
  `_margin_top` varchar(30) DEFAULT NULL,
  `_margin_bottom` varchar(30) DEFAULT NULL,
  `_margin_left` varchar(30) DEFAULT NULL,
  `_margin_right` varchar(30) DEFAULT NULL,
  `_show_model` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_form_settings`
--

INSERT INTO `purchase_form_settings` (`id`, `_default_inventory`, `_default_purchase`, `_default_discount`, `_default_vat_account`, `_opening_inventory`, `_default_capital`, `_show_barcode`, `_show_short_note`, `_show_unit`, `_show_vat`, `_inline_discount`, `_show_store`, `_show_self`, `_show_manufacture_date`, `_show_expire_date`, `_invoice_template`, `_show_p_balance`, `created_at`, `updated_at`, `_is_header`, `_is_footer`, `_margin_top`, `_margin_bottom`, `_margin_left`, `_margin_right`, `_show_model`) VALUES
(1, 6, 2, 11, 9, 12, 10, 0, 0, 1, 0, 0, 1, 0, 0, 0, 1, 0, '2022-04-14 18:43:06', '2024-01-02 11:33:39', 0, 0, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(100) DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_time` varchar(50) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_referance` varchar(255) DEFAULT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_term_condition` longtext DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_supplier_so_no` varchar(100) DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_delivery_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_accounts`
--

CREATE TABLE `purchase_order_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double NOT NULL DEFAULT 0,
  `_cr_amount` double NOT NULL DEFAULT 0,
  `_type` varchar(10) DEFAULT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_details`
--

CREATE TABLE `purchase_order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 1,
  `_store_id` int(11) NOT NULL DEFAULT 1,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_trans_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_budget_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_accounts`
--

CREATE TABLE `purchase_return_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_barcodes`
--

CREATE TABLE `purchase_return_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` double(15,4) NOT NULL DEFAULT 0.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_purchase_ref_id` int(11) NOT NULL DEFAULT 0,
  `_purchase_detal_ref` int(11) NOT NULL DEFAULT 0,
  `_barcode` varchar(255) DEFAULT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_form_settings`
--

CREATE TABLE `purchase_return_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL,
  `_default_purchase` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL DEFAULT 0,
  `_show_barcode` int(11) NOT NULL,
  `_show_vat` int(11) NOT NULL,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `_show_p_balance` int(11) NOT NULL DEFAULT 0,
  `_invoice_template` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_is_header` tinyint(4) NOT NULL DEFAULT 0,
  `_is_footer` tinyint(4) NOT NULL DEFAULT 0,
  `_margin_top` varchar(30) DEFAULT NULL,
  `_margin_bottom` varchar(30) DEFAULT NULL,
  `_margin_left` varchar(30) DEFAULT NULL,
  `_margin_right` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_return_form_settings`
--

INSERT INTO `purchase_return_form_settings` (`id`, `_default_inventory`, `_default_purchase`, `_default_discount`, `_default_vat_account`, `_show_barcode`, `_show_vat`, `_show_unit`, `_show_store`, `_show_self`, `_show_p_balance`, `_invoice_template`, `created_at`, `updated_at`, `_is_header`, `_is_footer`, `_margin_top`, `_margin_bottom`, `_margin_left`, `_margin_right`) VALUES
(1, 7, 3, 6, 51, 1, 1, 1, 1, 1, 0, 4, '2022-04-19 14:10:35', '2023-05-05 08:54:31', 0, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `quaterly_individual_insentives`
--

CREATE TABLE `quaterly_individual_insentives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_fescal_year` varchar(255) DEFAULT NULL,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_incentive_group` int(11) NOT NULL DEFAULT 0,
  `_insentive_year` varchar(255) DEFAULT NULL,
  `_insentive_quater_no` varchar(255) DEFAULT NULL,
  `_insentive_period_start` date DEFAULT NULL,
  `_insentive_period_end` date DEFAULT NULL,
  `_insentive_slap_no` varchar(255) DEFAULT NULL,
  `_slap_min_amount` double NOT NULL DEFAULT 0,
  `_slap_max_amount` double NOT NULL DEFAULT 0,
  `_incentive_rate` double NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quaterly_insentive_setups`
--

CREATE TABLE `quaterly_insentive_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_fescal_year` varchar(255) DEFAULT NULL,
  `_incentive_group` int(11) NOT NULL DEFAULT 0,
  `_insentive_year` varchar(255) DEFAULT NULL,
  `_insentive_quater_no` varchar(255) DEFAULT NULL,
  `_insentive_period_start` date DEFAULT NULL,
  `_insentive_period_end` date DEFAULT NULL,
  `_insentive_slap_no` varchar(255) DEFAULT NULL,
  `_slap_min_amount` double NOT NULL DEFAULT 0,
  `_slap_max_amount` double NOT NULL DEFAULT 0,
  `_incentive_rate` double NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receive_payments`
--

CREATE TABLE `receive_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_voucher_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(255) DEFAULT NULL,
  `_defalut_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_note` varchar(255) DEFAULT NULL,
  `_document` varchar(255) DEFAULT NULL,
  `_voucher_type` varchar(255) DEFAULT NULL,
  `_transection_type` varchar(255) DEFAULT NULL,
  `_transection_ref` varchar(255) DEFAULT NULL,
  `_form_name` varchar(255) DEFAULT NULL,
  `_ref_table` varchar(255) DEFAULT NULL,
  `_amount` double NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(200) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_confirm` tinyint(4) NOT NULL DEFAULT 0,
  `_confirm_by` int(11) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receive_payment_details`
--

CREATE TABLE `receive_payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(255) DEFAULT NULL,
  `_ref_id` int(11) NOT NULL DEFAULT 0,
  `_table` varchar(255) DEFAULT NULL,
  `_invoice_id` varchar(255) DEFAULT NULL,
  `_invoice_number` varchar(255) DEFAULT NULL,
  `_total` double NOT NULL DEFAULT 0,
  `_receive_amount` double NOT NULL DEFAULT 0,
  `_due_amount` double NOT NULL DEFAULT 0,
  `_collection_amount` double NOT NULL DEFAULT 0,
  `_due_balance` double NOT NULL DEFAULT 0,
  `_type` varchar(255) DEFAULT NULL,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_collection_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_short_narr` text DEFAULT NULL,
  `_is_adjust` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_is_effect` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replacement_form_settings`
--

CREATE TABLE `replacement_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_warranty_charge` int(11) NOT NULL,
  `_default_inventory` int(11) NOT NULL DEFAULT 0,
  `_default_sales` int(11) NOT NULL DEFAULT 0,
  `_default_cost_of_solds` int(11) NOT NULL DEFAULT 0,
  `_default_discount` int(11) NOT NULL DEFAULT 0,
  `_default_vat_account` int(11) NOT NULL DEFAULT 0,
  `_inline_discount` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL,
  `_show_vat` int(11) NOT NULL,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `_show_delivery_man` int(11) NOT NULL,
  `_show_sales_man` int(11) NOT NULL,
  `_show_cost_rate` int(11) NOT NULL,
  `_invoice_template` int(11) NOT NULL,
  `_show_warranty` int(11) NOT NULL,
  `_show_manufacture_date` int(11) NOT NULL,
  `_show_expire_date` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_is_header` tinyint(4) NOT NULL DEFAULT 0,
  `_is_footer` tinyint(4) NOT NULL DEFAULT 0,
  `_margin_top` varchar(30) DEFAULT NULL,
  `_margin_bottom` varchar(30) DEFAULT NULL,
  `_margin_left` varchar(30) DEFAULT NULL,
  `_margin_right` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `replacement_form_settings`
--

INSERT INTO `replacement_form_settings` (`id`, `_default_warranty_charge`, `_default_inventory`, `_default_sales`, `_default_cost_of_solds`, `_default_discount`, `_default_vat_account`, `_inline_discount`, `_show_barcode`, `_show_vat`, `_show_unit`, `_show_store`, `_show_self`, `_show_delivery_man`, `_show_sales_man`, `_show_cost_rate`, `_invoice_template`, `_show_warranty`, `_show_manufacture_date`, `_show_expire_date`, `created_at`, `updated_at`, `_is_header`, `_is_footer`, `_margin_top`, `_margin_bottom`, `_margin_left`, `_margin_right`) VALUES
(1, 42, 7, 4, 50, 8, 10, 1, 1, 1, 0, 1, 1, 1, 1, 1, 2, 1, 1, 1, '2023-01-10 08:51:00', '2023-04-24 19:47:10', 0, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `replacement_item_accounts`
--

CREATE TABLE `replacement_item_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replacement_item_ins`
--

CREATE TABLE `replacement_item_ins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_complain_detail_row_id` int(11) NOT NULL DEFAULT 0,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_warranty_reason` varchar(255) DEFAULT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_barcode` varchar(255) DEFAULT NULL,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_ait` double(15,4) NOT NULL DEFAULT 0.0000,
  `_ait_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_at` double(15,4) NOT NULL DEFAULT 0.0000,
  `_at_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_tti` double(15,4) NOT NULL DEFAULT 0.0000,
  `_tti_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replacement_item_outs`
--

CREATE TABLE `replacement_item_outs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replacement_masters`
--

CREATE TABLE `replacement_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_l_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rep_in_barcodes`
--

CREATE TABLE `rep_in_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rep_out_barcodes`
--

CREATE TABLE `rep_out_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_category_settings`
--

CREATE TABLE `restaurant_category_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_branch_ids` int(11) NOT NULL DEFAULT 0,
  `_category_ids` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurant_category_settings`
--

INSERT INTO `restaurant_category_settings` (`id`, `_branch_ids`, `_category_ids`, `created_at`, `updated_at`) VALUES
(1, 1, '44,105,111,41,10,63', '2023-05-02 10:08:56', '2023-05-16 10:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `resturant_details`
--

CREATE TABLE `resturant_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` double(15,4) NOT NULL DEFAULT 0.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_kitchen_item` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resturant_form_settings`
--

CREATE TABLE `resturant_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL,
  `_default_sales` int(11) NOT NULL,
  `_default_cost_of_solds` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL,
  `_inline_discount` int(11) NOT NULL DEFAULT 1,
  `_show_vat` int(11) NOT NULL,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_show_delivery_man` int(11) NOT NULL DEFAULT 0,
  `_show_sales_man` int(11) NOT NULL DEFAULT 0,
  `_show_cost_rate` int(11) NOT NULL DEFAULT 0,
  `_show_manufacture_date` int(11) NOT NULL DEFAULT 0,
  `_show_expire_date` int(11) NOT NULL DEFAULT 0,
  `_show_p_balance` int(11) NOT NULL DEFAULT 0,
  `_invoice_template` int(11) NOT NULL DEFAULT 0,
  `_show_warranty` tinyint(4) NOT NULL DEFAULT 0,
  `_cash_customer` text DEFAULT NULL,
  `_defaut_customer` int(11) NOT NULL DEFAULT 0,
  `_default_service_charge` int(11) NOT NULL DEFAULT 0,
  `_default_other_charge` int(11) NOT NULL DEFAULT 0,
  `_default_delivery_charge` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resturant_form_settings`
--

INSERT INTO `resturant_form_settings` (`id`, `_default_inventory`, `_default_sales`, `_default_cost_of_solds`, `_default_discount`, `_default_vat_account`, `_show_barcode`, `_inline_discount`, `_show_vat`, `_show_unit`, `_show_store`, `_show_self`, `created_at`, `updated_at`, `_show_delivery_man`, `_show_sales_man`, `_show_cost_rate`, `_show_manufacture_date`, `_show_expire_date`, `_show_p_balance`, `_invoice_template`, `_show_warranty`, `_cash_customer`, `_defaut_customer`, `_default_service_charge`, `_default_other_charge`, `_default_delivery_charge`) VALUES
(1, 7, 4, 50, 8, 10, 1, 1, 1, 0, 1, 1, '2022-04-26 10:54:55', '2023-05-04 19:36:47', 1, 1, 1, 1, 1, 1, 5, 1, '108', 121, 424, 425, 426);

-- --------------------------------------------------------

--
-- Table structure for table `resturant_sales`
--

CREATE TABLE `resturant_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_type_of_service` int(11) NOT NULL DEFAULT 0,
  `delivery_company_id` int(11) NOT NULL DEFAULT 0,
  `_order_ref_id` varchar(100) DEFAULT NULL,
  `_table_id` varchar(255) DEFAULT NULL,
  `_served_by_ids` varchar(255) DEFAULT NULL,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_service_charge` double(15,4) NOT NULL DEFAULT 0.0000,
  `_other_charge` double(15,4) NOT NULL DEFAULT 0.0000,
  `_delivery_charge` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_l_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(60) DEFAULT NULL COMMENT '''Hold'',''Sales''',
  `_delivery_status` varchar(60) DEFAULT NULL COMMENT '/Order,Processing,Transit,Deliverd,Cancel',
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_kitchen_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=yes,0=no',
  `_sales_spot` tinyint(4) NOT NULL DEFAULT 1 COMMENT '''Shop'',''Online''',
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resturant_sales_accounts`
--

CREATE TABLE `resturant_sales_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rlp_access_chains`
--

CREATE TABLE `rlp_access_chains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chain_type` text NOT NULL,
  `chain_name` text DEFAULT NULL,
  `organization_id` int(11) NOT NULL,
  `_branch_id` int(11) NOT NULL COMMENT 'branch id = branch or division id',
  `_cost_center_id` int(11) NOT NULL COMMENT 'cost center id = project_id',
  `department_id` int(11) NOT NULL,
  `rlp_type` int(11) NOT NULL,
  `users` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rlp_access_chains`
--

INSERT INTO `rlp_access_chains` (`id`, `chain_type`, `chain_name`, `organization_id`, `_branch_id`, `_cost_center_id`, `department_id`, `rlp_type`, `users`, `created_by`, `_user_id`, `updated_by`, `_status`, `created_at`, `updated_at`) VALUES
(1, 'RLP', 'Solar RLP Chain', 1, 1, 1, 1, 0, '', 51, 51, 0, 1, '2023-12-17 08:54:10', '2023-12-17 08:54:10');

-- --------------------------------------------------------

--
-- Table structure for table `rlp_access_chain_users`
--

CREATE TABLE `rlp_access_chain_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `chain_id` int(11) NOT NULL,
  `user_row_id` int(11) NOT NULL COMMENT 'Employee table ID',
  `user_id` varchar(255) NOT NULL,
  `user_group` int(11) NOT NULL DEFAULT 0,
  `_order` int(11) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rlp_access_chain_users`
--

INSERT INTO `rlp_access_chain_users` (`id`, `chain_id`, `user_row_id`, `user_id`, `user_group`, `_order`, `_status`, `created_at`, `updated_at`) VALUES
(1, 1, 659, 'SPL-000070', 1, 1, 1, '2023-12-17 08:54:10', '2023-12-17 08:54:10'),
(2, 1, 2239, 'SPL-008600', 1, 1, 1, '2023-12-17 08:54:10', '2023-12-17 08:54:10'),
(3, 1, 705, 'SPL-000393', 2, 2, 1, '2023-12-17 08:54:10', '2023-12-17 08:54:10'),
(4, 1, 2569, 'SPL-009207', 2, 2, 1, '2023-12-17 08:54:10', '2023-12-17 08:54:10'),
(5, 1, 2249, 'SPL-008615', 3, 3, 1, '2023-12-17 08:54:10', '2023-12-17 08:54:10'),
(6, 1, 657, 'SPL-000068', 3, 3, 1, '2023-12-17 08:54:10', '2023-12-17 08:54:10'),
(7, 1, 636, 'SPL-000004', 4, 4, 1, '2023-12-17 08:54:10', '2023-12-17 08:54:10');

-- --------------------------------------------------------

--
-- Table structure for table `rlp_account_details`
--

CREATE TABLE `rlp_account_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rlp_info_id` int(11) NOT NULL,
  `_rlp_ledger_id` int(11) NOT NULL,
  `_rlp_ledger_description` varchar(255) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `_details_remarks` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rlp_acknowledgements`
--

CREATE TABLE `rlp_acknowledgements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rlp_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_office_id` varchar(120) DEFAULT NULL,
  `ack_order` tinyint(4) NOT NULL,
  `ack_status` tinyint(4) NOT NULL DEFAULT 0,
  `ack_request_date` timestamp NULL DEFAULT NULL,
  `ack_updated_date` timestamp NULL DEFAULT NULL,
  `is_visible` tinyint(4) NOT NULL DEFAULT 0,
  `_is_approve` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rlp_delete_histories`
--

CREATE TABLE `rlp_delete_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rlp_info_id` int(11) NOT NULL,
  `deleted_by` text DEFAULT NULL,
  `deleted_at` date NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rlp_details`
--

CREATE TABLE `rlp_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rlp_info_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_item_description` varchar(255) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `_unit_id` int(11) NOT NULL,
  `unit_price` double NOT NULL DEFAULT 0,
  `amount` double NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_details_remarks` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rlp_masters`
--

CREATE TABLE `rlp_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL,
  `rlp_prefix` varchar(50) DEFAULT NULL,
  `_branch_id` int(11) NOT NULL COMMENT 'branch id = branch or division id',
  `_cost_center_id` int(11) NOT NULL COMMENT 'cost center id = project_id',
  `rlp_no` varchar(255) NOT NULL,
  `chain_id` int(11) NOT NULL DEFAULT 0,
  `rlp_user_id` int(11) NOT NULL,
  `rlp_user_office_id` varchar(255) NOT NULL,
  `priority` varchar(50) DEFAULT NULL,
  `request_date` date NOT NULL,
  `request_department` int(11) NOT NULL DEFAULT 0,
  `request_person` varchar(255) DEFAULT NULL,
  `designation` int(11) NOT NULL DEFAULT 0,
  `email` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `user_remarks` varchar(255) DEFAULT NULL,
  `_terms_condition` longtext DEFAULT NULL,
  `totalamount` double NOT NULL DEFAULT 0,
  `rlp_status` tinyint(4) NOT NULL DEFAULT 0,
  `is_viewed` tinyint(4) NOT NULL DEFAULT 0,
  `is_ns` tinyint(4) NOT NULL DEFAULT 0,
  `_status` int(11) NOT NULL DEFAULT 1,
  `_lock` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_ns_complete` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rlp_remarks`
--

CREATE TABLE `rlp_remarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rlp_info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_office_id` varchar(120) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `remarks_date` timestamp NULL DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rlp_user_groups`
--

CREATE TABLE `rlp_user_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_order` int(11) NOT NULL DEFAULT 1,
  `_display_name` varchar(255) DEFAULT NULL,
  `_color` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rlp_user_groups`
--

INSERT INTO `rlp_user_groups` (`id`, `_name`, `_order`, `_display_name`, `_color`, `_status`, `created_at`, `updated_at`) VALUES
(1, 'Maker', 1, 'Prepared By', '#a8e4a0', 1, '2023-10-21 22:53:16', NULL),
(2, 'Procurement', 2, 'Checked By', '#a0a8e4', 1, '2023-10-21 12:00:00', NULL),
(3, 'Checker', 3, 'Verified By', '#e4a0a8', 1, '2023-10-21 12:00:00', NULL),
(4, 'Approver', 4, 'Approved By', '#cae4a0', 1, '2023-10-21 12:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', 'admin', '2021-05-29 05:33:16', '2021-05-29 05:33:16'),
(3, 'TMM Accountant', 'web', 'visitor', '2021-06-04 05:59:56', '2023-12-19 15:22:12'),
(5, 'TMM Manager', 'web', 'admin', '2021-06-04 05:59:56', '2023-12-19 15:22:40'),
(6, 'TMM Procurement', 'web', 'visitor', '2022-06-08 12:09:38', '2023-12-19 15:23:15'),
(7, 'Admin Manager', 'web', 'visitor', '2022-06-08 14:03:45', '2022-06-08 14:03:45'),
(10, 'user', 'web', 'visitor', '2023-10-23 08:25:08', '2023-10-23 08:25:08'),
(11, 'TMM Inventory', 'web', 'admin', '2024-01-09 10:24:07', '2024-01-09 10:25:21'),
(12, 'Document Manager', 'web', 'visitor', '2024-05-28 05:42:37', '2024-05-28 05:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 6),
(1, 7),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(5, 3),
(5, 5),
(5, 6),
(5, 7),
(6, 1),
(6, 7),
(7, 1),
(7, 7),
(8, 1),
(9, 1),
(9, 3),
(9, 6),
(9, 7),
(10, 1),
(10, 3),
(10, 6),
(10, 7),
(11, 1),
(11, 3),
(11, 6),
(11, 7),
(12, 1),
(12, 3),
(13, 1),
(13, 3),
(13, 6),
(13, 7),
(14, 1),
(14, 3),
(14, 6),
(14, 7),
(15, 1),
(15, 3),
(15, 6),
(15, 7),
(16, 1),
(16, 3),
(17, 1),
(17, 7),
(18, 1),
(18, 7),
(19, 1),
(19, 7),
(20, 1),
(21, 1),
(21, 3),
(21, 5),
(21, 6),
(21, 7),
(22, 1),
(22, 3),
(22, 5),
(22, 7),
(23, 1),
(23, 3),
(23, 5),
(23, 7),
(24, 1),
(25, 1),
(25, 3),
(25, 6),
(25, 7),
(25, 11),
(26, 1),
(26, 3),
(26, 6),
(26, 7),
(27, 1),
(27, 3),
(27, 6),
(27, 7),
(28, 1),
(30, 1),
(30, 3),
(30, 6),
(30, 7),
(30, 11),
(31, 1),
(31, 3),
(31, 6),
(31, 7),
(31, 11),
(32, 1),
(32, 3),
(32, 6),
(32, 7),
(32, 11),
(33, 1),
(33, 3),
(34, 1),
(34, 3),
(34, 7),
(34, 11),
(35, 1),
(35, 3),
(35, 7),
(35, 11),
(36, 1),
(36, 3),
(36, 7),
(37, 1),
(38, 1),
(38, 3),
(38, 7),
(39, 1),
(39, 3),
(39, 6),
(39, 7),
(40, 1),
(40, 3),
(40, 7),
(41, 1),
(41, 3),
(41, 7),
(42, 1),
(42, 3),
(42, 7),
(43, 1),
(43, 3),
(43, 7),
(44, 1),
(44, 3),
(44, 7),
(45, 1),
(45, 3),
(45, 6),
(45, 7),
(46, 1),
(46, 3),
(46, 7),
(47, 1),
(47, 3),
(47, 5),
(47, 6),
(47, 7),
(48, 1),
(48, 5),
(48, 6),
(48, 7),
(48, 11),
(49, 1),
(49, 5),
(49, 6),
(49, 7),
(49, 11),
(50, 1),
(50, 5),
(50, 6),
(50, 7),
(50, 11),
(51, 1),
(51, 11),
(52, 1),
(52, 5),
(52, 6),
(52, 7),
(52, 11),
(53, 1),
(53, 5),
(53, 6),
(53, 7),
(53, 11),
(54, 1),
(54, 5),
(54, 6),
(54, 7),
(54, 11),
(55, 1),
(55, 11),
(56, 1),
(56, 6),
(56, 7),
(56, 11),
(57, 1),
(57, 6),
(57, 7),
(57, 11),
(58, 1),
(58, 6),
(58, 7),
(58, 11),
(59, 1),
(59, 11),
(60, 1),
(60, 5),
(60, 6),
(60, 7),
(60, 11),
(61, 1),
(61, 5),
(61, 6),
(61, 7),
(61, 11),
(62, 1),
(62, 5),
(62, 6),
(62, 7),
(62, 11),
(63, 1),
(63, 11),
(64, 1),
(64, 6),
(64, 7),
(64, 11),
(65, 1),
(65, 6),
(65, 7),
(65, 11),
(66, 1),
(66, 6),
(66, 7),
(66, 11),
(67, 1),
(67, 6),
(67, 7),
(67, 11),
(68, 1),
(68, 11),
(69, 1),
(69, 6),
(69, 7),
(69, 11),
(70, 1),
(70, 6),
(70, 7),
(70, 11),
(71, 1),
(71, 6),
(71, 7),
(71, 11),
(72, 7),
(73, 7),
(74, 7),
(76, 7),
(77, 7),
(78, 7),
(79, 7),
(80, 7),
(82, 7),
(83, 7),
(84, 1),
(84, 6),
(84, 7),
(84, 11),
(85, 1),
(85, 6),
(85, 7),
(85, 11),
(86, 1),
(86, 6),
(86, 7),
(86, 11),
(87, 1),
(87, 6),
(87, 7),
(87, 11),
(88, 1),
(88, 6),
(88, 7),
(88, 11),
(89, 1),
(89, 6),
(89, 7),
(90, 1),
(90, 6),
(90, 7),
(91, 1),
(91, 6),
(91, 7),
(92, 1),
(92, 6),
(92, 7),
(92, 11),
(93, 1),
(93, 6),
(93, 7),
(93, 11),
(94, 1),
(94, 6),
(94, 7),
(94, 11),
(95, 1),
(95, 6),
(95, 7),
(95, 11),
(96, 6),
(96, 7),
(97, 6),
(97, 7),
(98, 1),
(98, 6),
(98, 7),
(98, 11),
(99, 1),
(99, 6),
(99, 7),
(99, 11),
(100, 1),
(100, 6),
(100, 11),
(101, 1),
(101, 6),
(101, 7),
(101, 11),
(102, 1),
(102, 6),
(102, 7),
(102, 11),
(103, 1),
(103, 6),
(103, 7),
(103, 11),
(104, 6),
(104, 7),
(104, 11),
(105, 1),
(105, 7),
(105, 11),
(106, 1),
(106, 7),
(106, 11),
(107, 1),
(107, 7),
(107, 11),
(108, 1),
(108, 11),
(109, 1),
(109, 7),
(109, 11),
(110, 1),
(110, 7),
(110, 11),
(111, 1),
(111, 6),
(111, 7),
(111, 11),
(112, 1),
(112, 3),
(112, 7),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(116, 11),
(117, 1),
(117, 3),
(118, 7),
(119, 7),
(120, 7),
(121, 7),
(122, 7),
(123, 7),
(124, 7),
(125, 7),
(126, 7),
(127, 7),
(128, 7),
(129, 7),
(130, 7),
(131, 7),
(132, 7),
(133, 7),
(134, 7),
(135, 7),
(136, 7),
(137, 3),
(137, 7),
(138, 1),
(138, 3),
(139, 1),
(139, 11),
(140, 1),
(140, 11),
(141, 1),
(141, 11),
(142, 1),
(142, 11),
(143, 1),
(143, 3),
(144, 1),
(145, 1),
(146, 1),
(146, 3),
(147, 1),
(147, 3),
(148, 1),
(148, 3),
(148, 11),
(149, 1),
(149, 3),
(150, 1),
(150, 3),
(151, 1),
(151, 3),
(152, 1),
(152, 3),
(153, 1),
(153, 3),
(154, 1),
(154, 3),
(155, 1),
(155, 3),
(156, 1),
(157, 1),
(158, 1),
(159, 1),
(160, 1),
(161, 1),
(162, 1),
(163, 1),
(164, 1),
(164, 3),
(165, 1),
(165, 11),
(166, 1),
(166, 11),
(167, 1),
(167, 11),
(168, 1),
(168, 11),
(169, 11),
(170, 1),
(177, 1),
(178, 11),
(179, 11),
(180, 11),
(181, 11),
(182, 1),
(182, 11),
(203, 1),
(204, 1),
(204, 11),
(205, 1),
(205, 11),
(206, 1),
(206, 11),
(207, 1),
(207, 11),
(257, 1),
(258, 1),
(259, 3),
(260, 3),
(261, 3),
(264, 3),
(265, 3),
(266, 3),
(293, 1),
(294, 1),
(295, 1),
(296, 1),
(297, 1),
(298, 1),
(299, 1),
(300, 1),
(301, 1),
(302, 1),
(303, 1),
(304, 1),
(305, 1),
(306, 1),
(307, 1),
(308, 1),
(309, 1),
(310, 1),
(311, 1),
(312, 1),
(313, 1),
(314, 1),
(315, 1),
(316, 1),
(317, 1),
(318, 1),
(319, 1),
(319, 5),
(320, 1),
(320, 5),
(321, 1),
(321, 5),
(322, 1),
(323, 1),
(323, 5),
(324, 1),
(324, 5),
(325, 1),
(325, 5),
(326, 1),
(327, 1),
(327, 3),
(328, 1),
(329, 1),
(330, 1),
(331, 1),
(332, 1),
(333, 1),
(334, 1),
(335, 1),
(336, 1),
(336, 3),
(337, 1),
(337, 3),
(338, 1),
(338, 3),
(339, 1),
(340, 1),
(341, 1),
(342, 1),
(343, 1),
(344, 1),
(344, 5),
(345, 1),
(345, 11),
(346, 1),
(346, 11),
(347, 1),
(347, 11),
(348, 1),
(348, 11),
(349, 1),
(349, 11),
(350, 1),
(350, 11),
(351, 1),
(351, 11),
(352, 1),
(352, 11),
(353, 1),
(353, 11),
(354, 1),
(354, 11),
(355, 5),
(356, 5),
(357, 5),
(359, 1),
(359, 5),
(359, 6),
(359, 10),
(359, 11),
(360, 1),
(361, 1),
(361, 5),
(361, 6),
(361, 10),
(362, 1),
(362, 5),
(362, 6),
(362, 10),
(363, 1),
(363, 5),
(363, 6),
(363, 10),
(363, 11),
(364, 1),
(364, 5),
(364, 10),
(365, 1),
(366, 1),
(367, 1),
(368, 1),
(369, 1),
(375, 1),
(375, 11),
(389, 1),
(389, 11),
(390, 1),
(390, 11),
(391, 1),
(391, 11),
(392, 1),
(393, 1),
(394, 1),
(395, 1),
(396, 1),
(397, 1),
(398, 1),
(399, 1),
(400, 1),
(401, 1),
(402, 1),
(403, 1),
(404, 1),
(405, 1),
(405, 3),
(405, 5),
(405, 6),
(405, 11),
(405, 12),
(406, 1),
(406, 3),
(406, 5),
(406, 6),
(406, 11),
(406, 12),
(407, 1),
(407, 3),
(407, 5),
(407, 6),
(407, 11),
(407, 12),
(408, 1),
(408, 3),
(408, 5),
(408, 6),
(408, 11),
(408, 12),
(429, 1),
(432, 1),
(437, 1),
(438, 1),
(439, 1),
(440, 1),
(441, 1),
(442, 1),
(443, 1),
(444, 1),
(445, 1),
(446, 1),
(461, 1),
(462, 1),
(463, 1),
(464, 1),
(475, 1),
(476, 1),
(477, 1),
(478, 1),
(479, 1),
(480, 1),
(481, 1),
(482, 1),
(544, 1),
(545, 1),
(546, 1),
(547, 1),
(548, 1),
(549, 1),
(550, 1),
(551, 1),
(552, 1),
(553, 1),
(554, 1),
(555, 1),
(556, 1),
(557, 1),
(558, 1),
(559, 1),
(560, 1),
(561, 1),
(562, 1),
(563, 1),
(568, 1),
(569, 1),
(570, 1),
(571, 1),
(588, 1),
(611, 1),
(612, 1),
(613, 1),
(614, 1),
(615, 1),
(616, 1),
(617, 1),
(618, 1),
(619, 1),
(630, 1),
(642, 1),
(657, 1),
(658, 1),
(659, 1),
(660, 1),
(661, 1),
(662, 1),
(663, 1),
(664, 1),
(665, 1),
(674, 1),
(675, 1),
(689, 1),
(690, 1),
(691, 1),
(692, 1),
(701, 1),
(709, 1),
(710, 1),
(710, 3),
(711, 1),
(711, 3),
(712, 1),
(712, 3),
(713, 1),
(713, 3),
(714, 1),
(714, 3),
(715, 1),
(715, 3),
(716, 1),
(716, 3),
(717, 1),
(717, 3),
(718, 1),
(718, 3),
(719, 1),
(719, 3),
(720, 1),
(720, 3),
(721, 1),
(721, 3),
(722, 1),
(722, 3),
(723, 1),
(723, 3),
(724, 1),
(724, 3),
(725, 1),
(725, 3),
(726, 1),
(726, 3),
(727, 1),
(727, 3),
(728, 1),
(728, 3),
(729, 1),
(729, 3),
(730, 1),
(730, 3),
(731, 1),
(731, 3),
(732, 1),
(732, 3),
(733, 1),
(733, 3),
(734, 1),
(734, 3),
(735, 1),
(735, 3),
(736, 1),
(736, 3),
(737, 1),
(737, 3),
(738, 1),
(738, 3),
(739, 1),
(740, 1),
(741, 1),
(742, 1),
(743, 1),
(743, 3),
(744, 1),
(744, 3),
(745, 1),
(745, 3),
(746, 1),
(746, 3),
(747, 1),
(763, 1),
(763, 3),
(764, 1),
(764, 3),
(765, 1),
(765, 3),
(766, 1),
(766, 3),
(767, 1),
(767, 3),
(768, 1),
(768, 3),
(769, 1),
(769, 3),
(770, 1),
(770, 3),
(771, 1),
(771, 3),
(772, 1),
(772, 3),
(773, 1),
(773, 3),
(774, 1),
(774, 3),
(775, 1),
(775, 3),
(776, 1),
(776, 3),
(777, 1),
(777, 3),
(778, 1),
(778, 3),
(779, 1),
(779, 3),
(780, 1),
(780, 3),
(781, 1),
(781, 3),
(782, 1),
(782, 3),
(783, 1),
(783, 3),
(784, 1),
(784, 3),
(785, 1),
(785, 3),
(786, 1),
(786, 3),
(787, 1),
(787, 3),
(788, 1),
(788, 3);

-- --------------------------------------------------------

--
-- Table structure for table `saif_employee_db`
--

CREATE TABLE `saif_employee_db` (
  `id` int(11) NOT NULL,
  `EMP_ID` varchar(512) DEFAULT NULL,
  `EMP_NAME` varchar(512) DEFAULT NULL,
  `DIVISION` varchar(512) DEFAULT NULL,
  `DEPARTMENT` varchar(512) DEFAULT NULL,
  `DESIGNATION` varchar(512) DEFAULT NULL,
  `CATEGORY` varchar(512) DEFAULT NULL,
  `LOCATION` varchar(512) DEFAULT NULL,
  `JOIN_DATE` varchar(512) DEFAULT NULL,
  `EMP_GRADE` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_sheets`
--

CREATE TABLE `salary_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_month` int(11) NOT NULL DEFAULT 0,
  `_year` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `voucher_id` int(11) NOT NULL DEFAULT 0,
  `voucher_code` varchar(255) DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `salary_amount` decimal(10,0) NOT NULL DEFAULT 0,
  `allowance_amount` decimal(10,0) NOT NULL DEFAULT 0,
  `deduction_amount` decimal(10,0) NOT NULL DEFAULT 0,
  `net_payable_amount` decimal(10,0) NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `approve_by_1` int(11) NOT NULL DEFAULT 0,
  `approve_by_2` int(11) NOT NULL DEFAULT 0,
  `approve_by_3` int(11) NOT NULL DEFAULT 0,
  `approve_by_4` int(11) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(60) DEFAULT NULL,
  `_created_by` int(11) NOT NULL DEFAULT 0,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_is_posting` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_payment_terms` int(11) NOT NULL DEFAULT 1,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_vessel_no` int(11) NOT NULL DEFAULT 0,
  `_arrival_date_time` datetime DEFAULT NULL,
  `_discharge_date_time` datetime DEFAULT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_address` varchar(150) DEFAULT NULL,
  `_phone` varchar(50) DEFAULT NULL,
  `track_no` varchar(255) DEFAULT NULL,
  `driver_name` varchar(150) DEFAULT NULL,
  `driver_mob_no` varchar(100) DEFAULT NULL,
  `_delivery_details` text DEFAULT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_sd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_direct_sales` tinyint(4) NOT NULL DEFAULT 0,
  `_direct_purchase_no` varchar(200) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_loding_point` varchar(255) DEFAULT NULL,
  `_unloading_point` varchar(255) DEFAULT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 1,
  `_store_salves_id` varchar(100) DEFAULT NULL,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(50) DEFAULT NULL,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_print_counter` int(11) NOT NULL DEFAULT 0,
  `_challan_counter` int(11) NOT NULL DEFAULT 0,
  `_delivery_status` int(11) NOT NULL DEFAULT 0,
  `_online_inv_no` varchar(150) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `_mode_of_delivery` varchar(120) DEFAULT NULL,
  `_delivery_date` date DEFAULT NULL,
  `_receive_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_other_adjustment` double(15,4) NOT NULL DEFAULT 0.0000,
  `_due_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_trans_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_return_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_accounts`
--

CREATE TABLE `sales_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_barcodes`
--

CREATE TABLE `sales_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_commision_plans`
--

CREATE TABLE `sales_commision_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date DEFAULT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_start_date` date DEFAULT NULL,
  `_end_date` date DEFAULT NULL,
  `_fescal_year` varchar(255) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_details` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_commision_plan_details`
--

CREATE TABLE `sales_commision_plan_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_target_min` double NOT NULL DEFAULT 0,
  `_target_max` double NOT NULL DEFAULT 0,
  `_credit_limit` double NOT NULL DEFAULT 0,
  `_terms_id` int(11) NOT NULL DEFAULT 0,
  `_p_qty` double NOT NULL DEFAULT 0,
  `_bonus_qty` double NOT NULL DEFAULT 0,
  `_discount_rate` double NOT NULL DEFAULT 0,
  `_cash_discount_rate` double NOT NULL DEFAULT 0,
  `_gift_item` varchar(255) DEFAULT NULL,
  `_grade` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_details`
--

CREATE TABLE `sales_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_barcode` longtext DEFAULT NULL,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_expected_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sd_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_show_invoice` tinyint(4) NOT NULL DEFAULT 0,
  `_showing_item_name` text DEFAULT NULL,
  `sale_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `free_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_is_free` tinyint(4) NOT NULL DEFAULT 0,
  `_short_note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_form_settings`
--

CREATE TABLE `sales_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL,
  `_default_sales` int(11) NOT NULL,
  `_default_cost_of_solds` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL,
  `_default_sd_account` int(11) NOT NULL DEFAULT 0,
  `_show_barcode` int(11) NOT NULL,
  `_inline_discount` int(11) NOT NULL DEFAULT 1,
  `_show_vat` int(11) NOT NULL,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_is_header` tinyint(4) NOT NULL DEFAULT 0,
  `_is_footer` tinyint(4) NOT NULL DEFAULT 0,
  `_margin_top` varchar(30) DEFAULT NULL,
  `_margin_bottom` varchar(30) DEFAULT NULL,
  `_margin_left` varchar(30) DEFAULT NULL,
  `_margin_right` varchar(30) DEFAULT NULL,
  `_show_delivery_man` int(11) NOT NULL DEFAULT 0,
  `_show_sales_man` int(11) NOT NULL DEFAULT 0,
  `_show_cost_rate` int(11) NOT NULL DEFAULT 0,
  `_show_manufacture_date` int(11) NOT NULL DEFAULT 0,
  `_show_expire_date` int(11) NOT NULL DEFAULT 0,
  `_show_payment_terms` int(11) NOT NULL DEFAULT 0,
  `_show_p_balance` int(11) NOT NULL DEFAULT 0,
  `_show_due_history` tinyint(4) NOT NULL DEFAULT 0,
  `_invoice_template` int(11) NOT NULL DEFAULT 0,
  `_show_warranty` tinyint(4) NOT NULL DEFAULT 0,
  `_cash_customer` text DEFAULT NULL,
  `_defaut_customer` int(11) NOT NULL DEFAULT 0,
  `_seal_image` varchar(155) DEFAULT NULL,
  `_show_ar_date` tinyint(4) NOT NULL DEFAULT 0,
  `_show_dis_date` tinyint(4) NOT NULL DEFAULT 0,
  `_show_vn` tinyint(4) NOT NULL DEFAULT 0,
  `_show_expected_qty` tinyint(4) NOT NULL DEFAULT 0,
  `_show_sd` tinyint(4) NOT NULL DEFAULT 0,
  `_show_loding_point` tinyint(4) NOT NULL DEFAULT 0,
  `_show_unloading_point` tinyint(4) NOT NULL DEFAULT 0,
  `_default_cash_account` int(11) NOT NULL DEFAULT 0,
  `_show_default_cash` tinyint(4) NOT NULL DEFAULT 0,
  `_show_free_qty` int(11) NOT NULL DEFAULT 0,
  `_show_short_note` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_form_settings`
--

INSERT INTO `sales_form_settings` (`id`, `_default_inventory`, `_default_sales`, `_default_cost_of_solds`, `_default_discount`, `_default_vat_account`, `_default_sd_account`, `_show_barcode`, `_inline_discount`, `_show_vat`, `_show_unit`, `_show_store`, `_show_self`, `created_at`, `updated_at`, `_is_header`, `_is_footer`, `_margin_top`, `_margin_bottom`, `_margin_left`, `_margin_right`, `_show_delivery_man`, `_show_sales_man`, `_show_cost_rate`, `_show_manufacture_date`, `_show_expire_date`, `_show_payment_terms`, `_show_p_balance`, `_show_due_history`, `_invoice_template`, `_show_warranty`, `_cash_customer`, `_defaut_customer`, `_seal_image`, `_show_ar_date`, `_show_dis_date`, `_show_vn`, `_show_expected_qty`, `_show_sd`, `_show_loding_point`, `_show_unloading_point`, `_default_cash_account`, `_show_default_cash`, `_show_free_qty`, `_show_short_note`) VALUES
(1, 6, 4, 14, 7, 9, 9, 0, 0, 1, 1, 1, 0, '2022-04-26 10:54:55', '2023-11-22 19:31:05', 0, 0, '0px', '0px', '0px', '0px', 1, 1, 0, 0, 0, 0, 0, 0, 5, 0, '0', 0, NULL, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE `sales_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(100) DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `_time` varchar(50) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(200) DEFAULT NULL,
  `_phone` varchar(200) DEFAULT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_payment_terms` int(11) NOT NULL DEFAULT 0,
  `_online_inv_no` varchar(200) DEFAULT NULL,
  `_delivery_date` date DEFAULT NULL,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_order_type` int(11) NOT NULL DEFAULT 0,
  `_delivery_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_details`
--

CREATE TABLE `sales_order_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sale_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `free_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_show_invoice` tinyint(4) NOT NULL DEFAULT 0,
  `_showing_item_name` text DEFAULT NULL,
  `_short_note` varchar(200) DEFAULT NULL,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_returns`
--

CREATE TABLE `sales_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_address` varchar(200) DEFAULT NULL,
  `_phone` varchar(50) DEFAULT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 1,
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(60) DEFAULT NULL,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_loding_point` varchar(255) DEFAULT NULL,
  `_unloading_point` varchar(255) DEFAULT NULL,
  `_trans_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_budget_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_accounts`
--

CREATE TABLE `sales_return_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_barcodes`
--

CREATE TABLE `sales_return_barcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_id` int(11) NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_no_id` int(11) NOT NULL,
  `_no_detail_id` int(11) NOT NULL,
  `_qty` int(11) NOT NULL DEFAULT 1,
  `_barcode` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_details`
--

CREATE TABLE `sales_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_sales_ref_id` int(11) NOT NULL DEFAULT 0,
  `_sales_detail_ref_id` int(11) NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_barcode` varchar(255) DEFAULT NULL,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_short_note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_form_settings`
--

CREATE TABLE `sales_return_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_inventory` int(11) NOT NULL,
  `_default_sales` int(11) NOT NULL,
  `_default_cost_of_solds` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL,
  `_show_vat` int(11) NOT NULL,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_show_delivery_man` int(11) NOT NULL DEFAULT 0,
  `_show_sales_man` int(11) NOT NULL DEFAULT 0,
  `_show_cost_rate` int(11) NOT NULL DEFAULT 0,
  `_inline_discount` int(11) NOT NULL DEFAULT 0,
  `_show_expire_date` int(11) NOT NULL DEFAULT 0,
  `_show_manufacture_date` int(11) NOT NULL DEFAULT 0,
  `_show_p_balance` int(11) NOT NULL DEFAULT 0,
  `_invoice_template` int(11) NOT NULL DEFAULT 0,
  `_show_warranty` tinyint(4) NOT NULL DEFAULT 0,
  `_show_short_note` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_return_form_settings`
--

INSERT INTO `sales_return_form_settings` (`id`, `_default_inventory`, `_default_sales`, `_default_cost_of_solds`, `_default_discount`, `_default_vat_account`, `_show_barcode`, `_show_vat`, `_show_unit`, `_show_store`, `_show_self`, `created_at`, `updated_at`, `_show_delivery_man`, `_show_sales_man`, `_show_cost_rate`, `_inline_discount`, `_show_expire_date`, `_show_manufacture_date`, `_show_p_balance`, `_invoice_template`, `_show_warranty`, `_show_short_note`) VALUES
(1, 7, 5, 50, 8, 2, 1, 1, 1, 1, 1, '2022-04-29 04:53:06', '2023-04-28 20:55:10', 1, 1, 1, 1, 1, 1, 1, 4, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_wlms`
--

CREATE TABLE `sales_return_wlms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `sales_invoice_no` varchar(200) DEFAULT NULL,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_token_number` varchar(150) DEFAULT NULL,
  `track_no` varchar(60) DEFAULT NULL,
  `driver_name` varchar(60) DEFAULT NULL,
  `driver_mob_no` varchar(60) DEFAULT NULL,
  `_delivery_details` text DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double NOT NULL DEFAULT 0,
  `_discount_input` double NOT NULL DEFAULT 0,
  `_total_discount` double NOT NULL DEFAULT 0,
  `_total_vat` double NOT NULL DEFAULT 0,
  `_total` double NOT NULL DEFAULT 0,
  `_trans_amount` double NOT NULL DEFAULT 0,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_wlm_accounts`
--

CREATE TABLE `sales_return_wlm_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double NOT NULL DEFAULT 0,
  `_cr_amount` double NOT NULL DEFAULT 0,
  `_type` varchar(10) DEFAULT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_return_wlm_details`
--

CREATE TABLE `sales_return_wlm_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_sales_ref_id` int(11) NOT NULL DEFAULT 0,
  `_sales_number` varchar(255) DEFAULT NULL,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_sales_detail_ref_id` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_rate` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_discount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_vat` double NOT NULL DEFAULT 0,
  `_vat_amount` double NOT NULL DEFAULT 0,
  `_value` double NOT NULL DEFAULT 0,
  `_barcode` varchar(255) NOT NULL DEFAULT '0',
  `_warranty` varchar(255) NOT NULL DEFAULT '0',
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_without_lots`
--

CREATE TABLE `sales_without_lots` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `old_order_number` varchar(100) DEFAULT NULL,
  `_period` tinyint(4) NOT NULL DEFAULT 0,
  `BillNo` varchar(100) DEFAULT NULL,
  `AttnTo` varchar(200) DEFAULT NULL,
  `SealOf` varchar(200) DEFAULT NULL,
  `_online_inv_no` varchar(255) DEFAULT NULL,
  `_payment_terms` int(11) NOT NULL DEFAULT 0,
  `payment_date` date DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `track_no` varchar(60) DEFAULT NULL,
  `_token_number` varchar(100) DEFAULT NULL,
  `_number_of_print` int(11) NOT NULL DEFAULT 0,
  `driver_name` varchar(60) DEFAULT NULL,
  `driver_mob_no` varchar(60) DEFAULT NULL,
  `_delivery_details` text DEFAULT NULL,
  `_order_ref_id` varchar(11) DEFAULT NULL,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_sub_total` double NOT NULL DEFAULT 0,
  `_discount_input` double NOT NULL DEFAULT 0,
  `_total_discount` double NOT NULL DEFAULT 0,
  `_total_vat` double NOT NULL DEFAULT 0,
  `_total` double NOT NULL DEFAULT 0,
  `_p_balance` double NOT NULL DEFAULT 0,
  `_l_balance` double NOT NULL DEFAULT 0,
  `_trans_amount` double NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_delivery_man_id` int(11) NOT NULL DEFAULT 0,
  `_sales_type` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_is_bill` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_without_lot_accounts`
--

CREATE TABLE `sales_without_lot_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double NOT NULL DEFAULT 0,
  `_cr_amount` double NOT NULL DEFAULT 0,
  `_type` varchar(10) DEFAULT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_without_lot_details`
--

CREATE TABLE `sales_without_lot_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_item_code` varchar(100) DEFAULT NULL,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` double NOT NULL DEFAULT 0,
  `_base_rate` double NOT NULL DEFAULT 0,
  `_qty` double NOT NULL DEFAULT 0,
  `_rate` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_discount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_vat` double NOT NULL DEFAULT 0,
  `_vat_amount` double NOT NULL DEFAULT 0,
  `_value` double NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_show_invoice` tinyint(4) NOT NULL DEFAULT 0,
  `_is_free` tinyint(4) NOT NULL DEFAULT 0,
  `_showing_item_name` varchar(255) DEFAULT NULL,
  `_short_note` varchar(255) DEFAULT NULL,
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(150) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_deposits`
--

CREATE TABLE `security_deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date DEFAULT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_ledger_code` varchar(255) NOT NULL DEFAULT '0',
  `_type` varchar(255) NOT NULL,
  `_bank_name` varchar(200) DEFAULT NULL,
  `_bank_branch_name` varchar(200) DEFAULT NULL,
  `_cheque_no` varchar(255) DEFAULT NULL,
  `_cheque_date` varchar(255) DEFAULT NULL,
  `_amount` double NOT NULL DEFAULT 0,
  `_remarks` varchar(255) DEFAULT NULL,
  `_voucher_no` varchar(120) DEFAULT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_accounts`
--

CREATE TABLE `service_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_details`
--

CREATE TABLE `service_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float(10,4) NOT NULL DEFAULT 1.0000,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_short_note` varchar(255) DEFAULT NULL,
  `_service_name` varchar(255) DEFAULT NULL,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` int(11) NOT NULL DEFAULT 0,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_barcode` varchar(255) DEFAULT NULL,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_from_settings`
--

CREATE TABLE `service_from_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_service_income` int(11) NOT NULL,
  `_default_discount` int(11) NOT NULL,
  `_default_vat_account` int(11) NOT NULL,
  `_show_short_note` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL DEFAULT 1,
  `_show_service_name` int(11) NOT NULL,
  `_show_vat` int(11) NOT NULL,
  `_inline_discount` int(11) NOT NULL,
  `_invoice_template` int(11) NOT NULL DEFAULT 1,
  `_show_p_balance` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_from_settings`
--

INSERT INTO `service_from_settings` (`id`, `_default_service_income`, `_default_discount`, `_default_vat_account`, `_show_short_note`, `_show_barcode`, `_show_service_name`, `_show_vat`, `_inline_discount`, `_invoice_template`, `_show_p_balance`, `created_at`, `updated_at`) VALUES
(1, 435, 436, 10, 1, 1, 1, 1, 1, 2, 1, NULL, '2023-04-24 19:46:14');

-- --------------------------------------------------------

--
-- Table structure for table `service_masters`
--

CREATE TABLE `service_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_delivery_date` date DEFAULT NULL,
  `_time` varchar(60) NOT NULL,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_order_ref_id` varchar(255) DEFAULT NULL,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_discount_input` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_total_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sub_total` double NOT NULL DEFAULT 0,
  `_p_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_l_balance` double(15,4) NOT NULL DEFAULT 0.0000,
  `_apporoved_by` int(11) NOT NULL DEFAULT 0,
  `_service_by` varchar(255) DEFAULT NULL,
  `_service_status` int(11) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('RjUC9Ipt1vrvpK5Vj1sbUncGUXmwFjiV2IqhM8pF', 8, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZXFscGszdzNZa014T0tLQTNiWE1rVWN3TUdtOFZYNFR6U2NIYnM4OCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZGQtd2FsbGV0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEwJEFPVzJNTzVTRFBZVC9FeERMM25BSS41Q3l4bG1HT1VQekZZODNETS5GckQxaGdrV3pnSDdDIjtzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCRBT1cyTU81U0RQWVQvRXhETDNuQUkuNUN5eGxtR09VUHpGWTgzRE0uRnJEMWhna1d6Z0g3QyI7fQ==', 1630340574);

-- --------------------------------------------------------

--
-- Table structure for table `setting_key_values`
--

CREATE TABLE `setting_key_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_key` varchar(255) NOT NULL,
  `_value` longtext DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_media`
--

CREATE TABLE `social_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT 1,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sold_item_stock`
--

CREATE TABLE `sold_item_stock` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_category_id` int(11) NOT NULL DEFAULT 0,
  `_brand_id` int(11) NOT NULL DEFAULT 0,
  `_pack_size_id` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_unit_conversion` float NOT NULL DEFAULT 0,
  `_item` varchar(255) DEFAULT NULL,
  `_input_type` varchar(255) DEFAULT 'purchase',
  `_barcode` longtext DEFAULT NULL,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_qty` double NOT NULL DEFAULT 0,
  `_sales_rate` double NOT NULL DEFAULT 0,
  `_pur_rate` double NOT NULL DEFAULT 0,
  `_sales_discount` varchar(50) NOT NULL DEFAULT '0',
  `_sales_vat` varchar(50) NOT NULL DEFAULT '0',
  `_value` double NOT NULL DEFAULT 0,
  `_unit_id` int(11) NOT NULL DEFAULT 0,
  `_p_discount_input` int(11) NOT NULL DEFAULT 0,
  `_p_discount_amount` int(11) NOT NULL DEFAULT 0,
  `_p_vat` int(11) NOT NULL DEFAULT 0,
  `_p_vat_amount` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_master_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `is_lebel_print` tinyint(4) NOT NULL DEFAULT 0,
  `_receive_type` int(11) NOT NULL DEFAULT 0,
  `_unique_barcode` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_order_number` varchar(150) DEFAULT NULL,
  `_table_name` varchar(255) DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_item_category` varchar(100) DEFAULT NULL,
  `_transfer_to_asset` tinyint(4) NOT NULL DEFAULT 0,
  `_short_note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_details`
--

CREATE TABLE `status_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `bg_color` varchar(255) NOT NULL DEFAULT '#F5F5F5',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_details`
--

INSERT INTO `status_details` (`id`, `name`, `bg_color`, `created_at`, `updated_at`) VALUES
(1, 'Approve', '#C3FDB8', '2023-10-26 09:50:56', '2023-10-26 09:50:56'),
(2, 'Processing', '#31708f', '2023-10-26 09:50:56', '2023-10-26 09:50:56'),
(3, 'Reject', '#a94442', '2023-10-26 09:50:56', '2023-10-26 09:50:56'),
(4, 'On Held', '#8a6d3b', '2023-10-26 09:50:56', '2023-10-26 09:50:56'),
(5, 'Pending', '#FFDB58', '2023-10-26 09:50:56', '2023-10-26 09:50:56'),
(6, 'Recomended', '#00ADD6', '2023-10-26 09:50:56', '2023-10-26 09:50:56'),
(7, 'Draft', '#e57817', '2023-10-26 09:50:56', '2023-10-26 09:50:56');

-- --------------------------------------------------------

--
-- Table structure for table `steward_allocations`
--

CREATE TABLE `steward_allocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_branch_id` int(11) NOT NULL DEFAULT 1,
  `_ledgers` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stm_bill_collections`
--

CREATE TABLE `stm_bill_collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_ref_master_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(255) DEFAULT NULL,
  `_ref_detail_id` int(11) NOT NULL DEFAULT 0,
  `_short_narration` varchar(255) DEFAULT NULL,
  `_narration` varchar(255) DEFAULT NULL,
  `_reference` varchar(255) DEFAULT NULL,
  `_transaction` varchar(255) DEFAULT NULL,
  `_voucher_type` varchar(255) DEFAULT NULL,
  `_table_name` varchar(255) DEFAULT NULL,
  `_account_head` int(11) NOT NULL DEFAULT 0,
  `_account_group` int(11) NOT NULL DEFAULT 0,
  `_account_ledger` int(11) NOT NULL DEFAULT 0,
  `_dr_amount` double NOT NULL DEFAULT 0,
  `_cr_amount` double NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_fescal_period` varchar(255) DEFAULT NULL,
  `_check_no` varchar(255) DEFAULT NULL,
  `_check_number` varchar(255) DEFAULT NULL,
  `_issue_date` date DEFAULT NULL,
  `_cash_date` date DEFAULT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_pair` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_serial` double NOT NULL DEFAULT 0,
  `_f_currency` double NOT NULL DEFAULT 0,
  `_foreign_amount` double NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_created_by` int(11) NOT NULL DEFAULT 0,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stm_bill_masters`
--

CREATE TABLE `stm_bill_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_order_number` varchar(255) DEFAULT NULL,
  `_bill_type` varchar(255) DEFAULT NULL,
  `_month_id` int(11) NOT NULL DEFAULT 0,
  `_year` varchar(255) DEFAULT NULL,
  `_session_id` int(11) NOT NULL DEFAULT 0,
  `_stm_division_id` int(11) NOT NULL DEFAULT 0,
  `_class_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(255) DEFAULT NULL,
  `_dr_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_cr_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_number_of_student` double NOT NULL DEFAULT 0,
  `_total_amount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_net_amount` double NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stm_bill_master_details`
--

CREATE TABLE `stm_bill_master_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_student_id` int(11) NOT NULL DEFAULT 0,
  `_session_id` int(11) NOT NULL DEFAULT 0,
  `_stm_division_id` int(11) NOT NULL DEFAULT 0,
  `_class_id` int(11) NOT NULL DEFAULT 0,
  `_bill_type` varchar(50) DEFAULT NULL,
  `_month_id` int(11) NOT NULL DEFAULT 0,
  `_year` int(11) NOT NULL DEFAULT 0,
  `_fee_amount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_net_fee_amount` double NOT NULL DEFAULT 0,
  `_receive_amount` double NOT NULL DEFAULT 0,
  `_due_amount` double NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stm_classes`
--

CREATE TABLE `stm_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_code` varchar(60) DEFAULT NULL,
  `_detail` text DEFAULT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stm_classes`
--

INSERT INTO `stm_classes` (`id`, `_name`, `_code`, `_detail`, `_user_id`, `_user_name`, `_status`, `_lock`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(5, 'Play', 'Play', '', 46, 'Admin', 1, 0, NULL, NULL, '2025-05-12 16:51:44', '2025-05-12 16:51:44'),
(6, 'Nursery', 'Nursery', '', 46, 'Admin', 1, 0, NULL, NULL, '2025-05-12 16:52:08', '2025-05-12 16:52:08'),
(7, 'Class Two', 'Class Two', '', 46, 'Admin', 1, 0, NULL, NULL, '2025-05-12 16:52:25', '2025-05-12 16:52:25'),
(8, 'Class One', 'Class One', '', 46, 'Admin', 1, 0, NULL, NULL, '2025-05-12 16:52:39', '2025-05-12 16:52:39'),
(9, 'Nazera', 'Nazera', 'Nazera', 49, 'Shihab', 1, 0, NULL, NULL, '2025-05-19 11:50:06', '2025-05-19 11:50:06'),
(10, 'Hifzul Quran', 'Hifzul Quran', 'Hifzul Quran', 49, 'Shihab', 1, 0, NULL, NULL, '2025-05-19 11:52:11', '2025-05-19 11:52:11'),
(11, 'Hifz Revision', 'Hifz Revision', 'Hifz Revision', 49, 'Shihab', 1, 0, NULL, NULL, '2025-05-19 11:53:02', '2025-05-19 11:53:02');

-- --------------------------------------------------------

--
-- Table structure for table `stm_collection_masters`
--

CREATE TABLE `stm_collection_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date NOT NULL,
  `_roshid_book_no` varchar(60) DEFAULT NULL,
  `_roshid_no` varchar(60) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_order_number` varchar(255) DEFAULT NULL,
  `_bill_type` varchar(255) DEFAULT NULL,
  `_month_id` int(11) NOT NULL DEFAULT 0,
  `_year` varchar(255) DEFAULT NULL,
  `_stm_division_id` int(11) NOT NULL DEFAULT 0,
  `_session_id` int(11) NOT NULL DEFAULT 0,
  `_class_id` int(11) NOT NULL DEFAULT 0,
  `_student_table_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(255) DEFAULT NULL,
  `_dr_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_cr_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_number_of_student` double NOT NULL DEFAULT 0,
  `_total_amount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_net_amount` double NOT NULL DEFAULT 0,
  `_note` text DEFAULT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `stm_bill_masters_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_confirm` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stm_collection_master_details`
--

CREATE TABLE `stm_collection_master_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_session_id` int(11) NOT NULL DEFAULT 0,
  `_student_id` int(11) NOT NULL DEFAULT 0,
  `_bill_master_id` int(11) NOT NULL DEFAULT 0,
  `_bill_detail_id` int(11) NOT NULL DEFAULT 0,
  `_stm_division_id` int(11) NOT NULL DEFAULT 0,
  `_class_id` int(11) NOT NULL DEFAULT 0,
  `_bill_type` varchar(60) DEFAULT NULL,
  `_collection_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_fee_amount` double NOT NULL DEFAULT 0,
  `_discount_amount` double NOT NULL DEFAULT 0,
  `_net_fee_amount` double NOT NULL DEFAULT 0,
  `_receive_amount` double NOT NULL DEFAULT 0,
  `_collection_amount` double NOT NULL DEFAULT 0,
  `_due_amount` double NOT NULL DEFAULT 0,
  `_due_balance` double NOT NULL DEFAULT 0,
  `_remarks` varchar(255) DEFAULT NULL,
  `_short_narr` text DEFAULT NULL,
  `_month_id` int(11) NOT NULL DEFAULT 0,
  `_year` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_is_effect` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stm_divisions`
--

CREATE TABLE `stm_divisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_code` varchar(200) DEFAULT NULL,
  `_detail` text DEFAULT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stm_divisions`
--

INSERT INTO `stm_divisions` (`id`, `_name`, `_code`, `_detail`, `_user_id`, `_user_name`, `_status`, `_lock`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(4, 'Ibtedai', 'Ibtedai', '', 46, 'Admin', 1, 0, NULL, NULL, '2025-05-12 16:53:20', '2025-05-12 16:53:20'),
(5, 'Ibtedai + Nazera', 'Ibtedai + Nazera', '', 46, 'Admin', 1, 0, NULL, NULL, '2025-05-12 16:53:52', '2025-05-12 16:53:52'),
(6, 'Nazera', 'Nazera', '', 46, 'Admin', 1, 0, NULL, NULL, '2025-05-12 16:54:05', '2025-05-12 16:54:05'),
(7, 'Hifz', 'Hifz', 'Hifz', 49, 'Shihab', 1, 0, NULL, NULL, '2025-05-18 14:24:03', '2025-05-18 14:27:31');

-- --------------------------------------------------------

--
-- Table structure for table `stm_division_class_students`
--

CREATE TABLE `stm_division_class_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_student_id` int(11) NOT NULL DEFAULT 0,
  `_admission_date` date DEFAULT NULL,
  `_division_id` int(11) NOT NULL DEFAULT 0,
  `_class_id` int(11) NOT NULL DEFAULT 0,
  `_class_name` varchar(70) DEFAULT NULL,
  `_roll_no` varchar(255) DEFAULT NULL,
  `_session` varchar(255) DEFAULT NULL,
  `_promoted` varchar(255) DEFAULT NULL,
  `_admission_fee` double NOT NULL DEFAULT 0,
  `_tution_fee` double NOT NULL DEFAULT 0,
  `_anual_fee` double NOT NULL DEFAULT 0,
  `_exam_fee` double NOT NULL DEFAULT 0,
  `_monthly_food_fee` double NOT NULL DEFAULT 0,
  `_residential_fee` double NOT NULL DEFAULT 0,
  `_other_fee` double NOT NULL DEFAULT 0,
  `_other_2_fee` double NOT NULL DEFAULT 0,
  `_other_3_fee` double NOT NULL DEFAULT 0,
  `_main_subjects` text DEFAULT NULL,
  `_optional_subjects` text DEFAULT NULL,
  `_start_date` date DEFAULT NULL,
  `_end_date` date DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stm_division_class_students`
--

INSERT INTO `stm_division_class_students` (`id`, `_student_id`, `_admission_date`, `_division_id`, `_class_id`, `_class_name`, `_roll_no`, `_session`, `_promoted`, `_admission_fee`, `_tution_fee`, `_anual_fee`, `_exam_fee`, `_monthly_food_fee`, `_residential_fee`, `_other_fee`, `_other_2_fee`, `_other_3_fee`, `_main_subjects`, `_optional_subjects`, `_start_date`, `_end_date`, `_status`, `_lock`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(89, 90, '2024-12-12', 4, 5, 'Play', '03', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(90, 91, '2024-12-24', 4, 5, 'Play', '07', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(91, 92, '2024-12-21', 4, 5, 'Play', '06', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(92, 93, '2024-12-15', 4, 5, 'Play', '05', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(93, 94, '2024-12-09', 4, 5, 'Play', '02', '1', NULL, 600, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:05', '2025-05-13 10:17:43'),
(94, 95, '2025-01-06', 4, 5, 'Play', '11', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(95, 96, '2025-01-07', 4, 5, 'Play', '12', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(96, 97, '2025-01-11', 4, 5, 'Play', '14', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(97, 98, '2025-01-14', 4, 5, 'Play', '16', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(98, 99, '2025-01-04', 4, 5, 'Play', '10', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(99, 100, '2024-01-20', 4, 5, 'Play', '17', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(100, 101, '2024-12-15', 4, 5, 'Play', '04', '1', NULL, 600, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-13 10:20:25'),
(101, 102, '2024-02-24', 4, 5, 'Play', '08', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(102, 103, '2023-12-20', 4, 5, 'Play', '13', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(103, 104, '2024-01-31', 4, 5, 'Play', '09', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(104, 105, '2025-04-09', 4, 5, 'Play', '18', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(105, 106, '2025-01-02', 4, 5, 'Play', '01', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(106, 107, '2025-01-13', 4, 5, 'Play', '15', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(107, 108, '2024-01-10', 4, 6, 'Nursery', '01', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(108, 109, '2023-12-21', 4, 6, 'Nursery', '02', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(109, 110, '2023-12-10', 4, 6, 'Nursery', '03', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(110, 111, '2023-12-01', 4, 6, 'Nursery', '04', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(111, 112, '2024-01-01', 4, 6, 'Nursery', '05', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(112, 113, '2024-01-04', 4, 6, 'Nursery', '07', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(113, 114, '2013-12-01', 4, 6, 'Nursery', '08', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(114, 115, '2026-12-23', 4, 6, 'Nursery', '09', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(115, 116, '2024-12-31', 4, 6, 'Nursery', '10', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(116, 117, '2023-12-03', 4, 6, 'Nursery', '11', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(117, 118, '2024-01-04', 4, 6, 'Nursery', '12', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(118, 119, '2023-12-19', 4, 6, 'Nursery', '13', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(119, 120, '2023-12-25', 4, 6, 'Nursery', '14', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(120, 121, '2023-12-28', 4, 6, 'Nursery', '15', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(121, 122, '2024-01-13', 4, 6, 'Nursery', '16', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(122, 123, '2023-12-27', 4, 6, 'Nursery', '17', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(123, 124, '2023-12-12', 4, 6, 'Nursery', '18', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(124, 125, '2023-12-26', 4, 6, 'Nursery', '19', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(125, 126, '2024-01-25', 4, 6, 'Nursery', '20', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(126, 127, '2024-01-03', 4, 6, 'Nursery', '21', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(127, 128, '2023-12-12', 4, 6, 'Nursery', '22', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(128, 129, '2024-01-27', 4, 6, 'Nursery', '23', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(129, 130, '2024-01-17', 4, 6, 'Nursery', '24', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(130, 131, '2024-02-24', 4, 6, 'Nursery', '25', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(131, 132, '2024-12-09', 4, 6, 'Nursery', '26', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(132, 133, '2024-12-10', 4, 6, 'Nursery', '27', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(133, 134, '2024-12-24', 4, 6, 'Nursery', '28', '1', NULL, 600, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-13 09:52:52'),
(134, 135, '2024-02-17', 4, 6, 'Nursery', '31', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(135, 136, '2025-04-19', 4, 6, 'Nursery', '32', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(136, 137, '2025-01-04', 4, 6, 'Nursery', '30', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(137, 138, '2025-01-02', 4, 6, 'Nursery', '29', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(138, 139, '2024-03-06', 4, 6, 'Nursery', '06', '1', NULL, 500, 200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(139, 140, '2023-12-23', 4, 8, 'Class One', '01', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(140, 141, '2023-12-06', 4, 8, 'Class One', '02', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(141, 142, '2023-12-02', 4, 8, 'Class One', '03', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(142, 143, '2023-12-02', 4, 8, 'Class One', '04', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(143, 144, '2024-01-31', 4, 8, 'Class One', '05', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(144, 145, '2023-12-24', 4, 8, 'Class One', '06', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(145, 146, '2024-01-01', 4, 8, 'Class One', '07', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(146, 147, '2023-12-20', 4, 8, 'Class One', '08', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(147, 148, '2023-12-01', 4, 8, 'Class One', '09', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(148, 149, '2024-01-01', 4, 8, 'Class One', '10', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(149, 150, '2023-12-25', 4, 8, 'Class One', '12', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(150, 151, '2023-12-20', 4, 8, 'Class One', '13', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(151, 152, '2024-01-10', 4, 8, 'Class One', '14', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(152, 153, '2023-12-02', 4, 8, 'Class One', '15', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(153, 154, '2023-12-04', 4, 8, 'Class One', '16', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(154, 155, '2024-01-13', 4, 8, 'Class One', '17', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(155, 156, '2023-12-20', 4, 8, 'Class One', '18', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(156, 157, '2024-12-28', 4, 8, 'Class One', '19', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(157, 158, '2025-01-25', 4, 8, 'Class One', '20', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(158, 159, '2025-03-02', 4, 8, 'Class One', '21', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(159, 160, '2025-04-15', 4, 8, 'Class One', '22', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(160, 161, '2024-07-16', 4, 8, 'Class One', '11', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(161, 162, '2024-01-01', 4, 7, 'Class Two', '03', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(162, 163, '2014-01-01', 4, 7, 'Class Two', '01', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(163, 164, '2023-12-16', 4, 7, 'Class Two', '04', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(164, 165, '2023-12-16', 4, 7, 'Class Two', '02', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(165, 166, '2024-01-31', 4, 7, 'Class Two', '10', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(166, 167, '2023-12-24', 4, 7, 'Class Two', '11', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(167, 168, '2023-12-11', 5, 7, 'Class Two', '06', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(168, 169, '2025-01-22', 5, 7, 'Class Two', '13', '1', NULL, 600, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-13 09:07:21'),
(169, 170, '2023-12-26', 5, 7, 'Class Two', '09', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(170, 171, '2025-02-17', 5, 7, 'Class Two', '15', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(171, 172, '2024-01-11', 5, 7, 'Class Two', '07', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(172, 173, '2023-12-23', 5, 7, 'Class Two', '05', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(173, 174, '1970-01-01', 5, 7, 'Class Two', '12', '1', NULL, 600, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:08', '2025-05-13 09:10:00'),
(174, 175, '2025-01-05', 5, 7, 'Class Two', '14', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(175, 176, '2024-06-01', 4, 7, 'Class Two', '08', '1', NULL, 500, 250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(176, 177, NULL, 7, 10, NULL, '20', '1', '0', 600, 2500, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 1, '49', NULL, '2025-05-19 12:01:16', '2025-05-19 15:45:00'),
(177, 178, '2025-04-22', 6, 10, 'Hifzul Quran', '23', '1', NULL, 500, 2500, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(178, 179, '2023-09-24', 6, 10, 'Hifzul Quran', '02', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(179, 180, '2024-05-04', 6, 10, 'Hifzul Quran', '04', '1', NULL, 500.01, 1000, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(180, 181, '2024-05-04', 6, 10, 'Hifzul Quran', '06', '1', NULL, 500.01, 1000, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(181, 182, '2024-12-22', 6, 10, 'Hifzul Quran', '07', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(182, 183, '2024-05-04', 6, 10, 'Hifzul Quran', '09', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(183, 184, '2024-05-04', 6, 10, 'Hifzul Quran', '10', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(184, 185, '2024-05-04', 6, 10, 'Hifzul Quran', '11', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(185, 186, '2023-12-31', 6, 10, 'Hifzul Quran', '13', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(186, 187, '2004-05-24', 6, 10, 'Hifzul Quran', '15', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(187, 188, '2024-05-04', 6, 10, 'Hifzul Quran', '16', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(188, 189, '2024-05-04', 6, 10, 'Hifzul Quran', '17', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(189, 190, '2024-12-01', 6, 10, 'Hifzul Quran', '18', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(190, 191, '2025-01-26', 6, 10, 'Hifzul Quran', '21', '1', NULL, 500, 2300, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(191, 192, '2025-02-12', 6, 10, 'Hifzul Quran', '22', '1', NULL, 500, 2300, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(192, 193, '2022-07-22', 7, 10, 'Hifzul Quran', '01', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(193, 194, '2021-02-10', 7, 10, 'Hifzul Quran', '02', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(194, 195, '2022-05-25', 7, 10, 'Hifzul Quran', '03', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(195, 196, '2022-06-26', 7, 10, 'Hifzul Quran', '05', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(196, 197, '2018-12-24', 7, 10, 'Hifzul Quran', '06', '1', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(197, 198, '2022-06-26', 7, 10, 'Hifzul Quran', '07', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(198, 199, '2021-02-05', 7, 10, 'Hifzul Quran', '08', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(199, 200, '2022-05-26', 7, 10, 'Hifzul Quran', '09', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(200, 201, '2022-09-20', 7, 10, 'Hifzul Quran', '10', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(201, 202, '2022-05-15', 7, 10, 'Hifzul Quran', '11', '1', NULL, 0, 1000, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(202, 203, '2020-01-28', 7, 10, 'Hifzul Quran', '12', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(203, 204, '2022-05-15', 7, 10, 'Hifzul Quran', '13', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(204, 205, '2023-02-25', 7, 10, 'Hifzul Quran', '14', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(205, 206, '2022-09-20', 7, 10, 'Hifzul Quran', '15', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(206, 207, '2022-07-10', 7, 10, 'Hifzul Quran', '16', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(207, 208, '2023-12-18', 7, 10, 'Hifzul Quran', '17', '1', NULL, 500, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(208, 209, '2022-05-14', 7, 10, 'Hifzul Quran', '18', '1', NULL, 0, 1200, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(209, 210, '2020-01-28', 7, 10, 'Hifzul Quran', '20', '1', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(210, 211, '2024-12-04', 7, 10, 'Hifzul Quran', '21', '1', NULL, 500, 2300, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(211, 212, '2025-04-10', 7, 10, 'Hifzul Quran', '22', '1', NULL, 500, 2500, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, NULL, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(212, 213, NULL, 7, 10, NULL, '19', '1', '0', 1, 1, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 1, '49', NULL, '2025-05-22 16:07:05', '2025-05-22 16:28:12'),
(213, 213, NULL, 7, 10, NULL, '4', '1', NULL, 0, 1250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 0, '46', '46', '2025-05-22 16:24:26', '2025-05-22 16:28:12'),
(214, 213, NULL, 7, 10, NULL, '4', '1', NULL, 500, 1250, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, '46', '46', '2025-05-22 16:26:18', '2025-05-22 16:28:12'),
(215, 214, NULL, 7, 10, NULL, '19', '1', '0', 1, 1, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0, 1, '49', NULL, '2025-05-22 16:34:00', '2025-05-25 11:15:03'),
(216, 214, NULL, 7, 10, NULL, '19', '1', NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, '46', '46', '2025-05-25 11:13:04', '2025-05-25 11:15:03');

-- --------------------------------------------------------

--
-- Table structure for table `stm_education_sessions`
--

CREATE TABLE `stm_education_sessions` (
  `id` int(11) NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_detail` text DEFAULT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stm_education_sessions`
--

INSERT INTO `stm_education_sessions` (`id`, `_name`, `_code`, `_detail`, `_user_id`, `_user_name`, `_status`, `_lock`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(1, '2025-2026', '2025-2026', NULL, 46, 'admin', 1, 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `stm_income_ledger_setups`
--

CREATE TABLE `stm_income_ledger_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_admission_fee_ledger` int(11) NOT NULL DEFAULT 0,
  `_tution_fee_ledger` int(11) NOT NULL DEFAULT 0,
  `_anual_fee_ledger` int(11) NOT NULL DEFAULT 0,
  `_exam_fee_ledger` int(11) NOT NULL DEFAULT 0,
  `_monthly_food_fee_ledger` int(11) NOT NULL DEFAULT 0,
  `_residential_fee_ledger` int(11) NOT NULL DEFAULT 0,
  `_other_fee_ledger` int(11) NOT NULL DEFAULT 0,
  `_other_2_fee_ledger` int(11) NOT NULL DEFAULT 0,
  `_other_3_fee_ledger` int(11) NOT NULL DEFAULT 0,
  `_discount_ledger` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stm_income_ledger_setups`
--

INSERT INTO `stm_income_ledger_setups` (`id`, `_admission_fee_ledger`, `_tution_fee_ledger`, `_anual_fee_ledger`, `_exam_fee_ledger`, `_monthly_food_fee_ledger`, `_residential_fee_ledger`, `_other_fee_ledger`, `_other_2_fee_ledger`, `_other_3_fee_ledger`, `_discount_ledger`, `_status`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(2, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 0, NULL, 'Admin', NULL, '2025-05-12 17:38:36');

-- --------------------------------------------------------

--
-- Table structure for table `stm_students`
--

CREATE TABLE `stm_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_user_table_id` int(11) NOT NULL DEFAULT 0,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_account_group_id` int(11) NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_roll_no` int(11) NOT NULL DEFAULT 0,
  `_admission_date` date NOT NULL,
  `_admission_session_id` int(11) NOT NULL DEFAULT 0,
  `_education_type` int(11) NOT NULL DEFAULT 0,
  `_admission_class_id` int(11) NOT NULL DEFAULT 0,
  `_current_class_id` int(11) NOT NULL DEFAULT 0,
  `_student_id` varchar(255) DEFAULT NULL,
  `_proximity_card_no` varchar(255) DEFAULT NULL,
  `_name_in_english` varchar(255) DEFAULT NULL,
  `_name_in_bangla` varchar(255) DEFAULT NULL,
  `_religion` varchar(100) DEFAULT NULL,
  `_student_image` varchar(255) DEFAULT NULL,
  `_gender` varchar(255) DEFAULT NULL,
  `_email` varchar(200) DEFAULT NULL,
  `_date_of_birth` date DEFAULT NULL,
  `_barth_id` varchar(255) DEFAULT NULL,
  `_bloodgroup` varchar(255) DEFAULT NULL,
  `_s_identification_mark` varchar(255) DEFAULT NULL,
  `_age` varchar(255) DEFAULT NULL,
  `_nationality` varchar(255) DEFAULT NULL,
  `_height` varchar(255) DEFAULT NULL,
  `_weight` varchar(255) DEFAULT NULL,
  `_father_name_bangla` varchar(255) DEFAULT NULL,
  `_father_name_english` varchar(255) DEFAULT NULL,
  `_occupation` varchar(255) DEFAULT NULL,
  `_annual_income` varchar(255) DEFAULT NULL,
  `_f_mobile_no` varchar(255) DEFAULT NULL,
  `_f_nid_no` varchar(255) DEFAULT NULL,
  `_f_email` varchar(255) DEFAULT NULL,
  `_mother_name_english` varchar(200) DEFAULT NULL,
  `_mother_name_of_bangla` varchar(255) DEFAULT NULL,
  `_mother_occupation` varchar(255) DEFAULT NULL,
  `_mother_mobile_no` varchar(100) DEFAULT NULL,
  `_mother_anual_income` varchar(255) DEFAULT NULL,
  `_mother_nid_no` varchar(255) DEFAULT NULL,
  `_mother_email` varchar(255) DEFAULT NULL,
  `_local_guardian_name` varchar(255) DEFAULT NULL,
  `_local_guardian_occupation` varchar(200) DEFAULT NULL,
  `_local_guardian_address` varchar(255) DEFAULT NULL,
  `_local_guardian_mobile` varchar(255) DEFAULT NULL,
  `_local_guardian_nid` varchar(255) DEFAULT NULL,
  `_local_guardian_nid_image` varchar(255) DEFAULT NULL,
  `_present_address` text DEFAULT NULL,
  `_per_country_id` int(11) DEFAULT NULL,
  `_per_division_id` int(11) DEFAULT NULL,
  `_per_district_id` int(11) DEFAULT NULL,
  `_per_thana_id` varchar(150) DEFAULT NULL,
  `_per_union_id` int(11) DEFAULT NULL,
  `_cur_division_id` int(11) DEFAULT NULL,
  `_cur_country_id` int(11) DEFAULT NULL,
  `_cur_district_id` int(11) DEFAULT NULL,
  `_cur_thana_id` varchar(200) DEFAULT NULL,
  `_cur_union_id` int(11) DEFAULT NULL,
  `_per_post_office` varchar(100) DEFAULT NULL,
  `_cur_post_office` varchar(100) DEFAULT NULL,
  `_parmanent_address` text DEFAULT NULL,
  `_previous_institute_name` varchar(255) DEFAULT NULL,
  `_pre_class` varchar(255) DEFAULT NULL,
  `_pre_result` varchar(255) DEFAULT NULL,
  `_pre_roll_no` varchar(255) DEFAULT NULL,
  `_father_nid_image` varchar(255) DEFAULT NULL,
  `_mother_nid_image` varchar(255) DEFAULT NULL,
  `_birth_certificate` varchar(255) DEFAULT NULL,
  `_transfer_certificate` varchar(255) DEFAULT NULL,
  `_testimonial` varchar(255) DEFAULT NULL,
  `_academic_certificate` varchar(255) DEFAULT NULL,
  `_marksheet` varchar(255) DEFAULT NULL,
  `_student_photo` varchar(255) DEFAULT NULL,
  `_adminssion_fee_amount` double DEFAULT NULL,
  `_monthly_fee` double DEFAULT NULL,
  `_resedential_type` varchar(255) DEFAULT NULL,
  `_parents_signature` varchar(255) DEFAULT NULL,
  `_main_subjects` text DEFAULT NULL,
  `_optional_subjects` text DEFAULT NULL,
  `_detail` text DEFAULT NULL,
  `_user_id` int(11) DEFAULT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stm_students`
--

INSERT INTO `stm_students` (`id`, `_user_table_id`, `organization_id`, `_branch_id`, `_account_group_id`, `_ledger_id`, `_roll_no`, `_admission_date`, `_admission_session_id`, `_education_type`, `_admission_class_id`, `_current_class_id`, `_student_id`, `_proximity_card_no`, `_name_in_english`, `_name_in_bangla`, `_religion`, `_student_image`, `_gender`, `_email`, `_date_of_birth`, `_barth_id`, `_bloodgroup`, `_s_identification_mark`, `_age`, `_nationality`, `_height`, `_weight`, `_father_name_bangla`, `_father_name_english`, `_occupation`, `_annual_income`, `_f_mobile_no`, `_f_nid_no`, `_f_email`, `_mother_name_english`, `_mother_name_of_bangla`, `_mother_occupation`, `_mother_mobile_no`, `_mother_anual_income`, `_mother_nid_no`, `_mother_email`, `_local_guardian_name`, `_local_guardian_occupation`, `_local_guardian_address`, `_local_guardian_mobile`, `_local_guardian_nid`, `_local_guardian_nid_image`, `_present_address`, `_per_country_id`, `_per_division_id`, `_per_district_id`, `_per_thana_id`, `_per_union_id`, `_cur_division_id`, `_cur_country_id`, `_cur_district_id`, `_cur_thana_id`, `_cur_union_id`, `_per_post_office`, `_cur_post_office`, `_parmanent_address`, `_previous_institute_name`, `_pre_class`, `_pre_result`, `_pre_roll_no`, `_father_nid_image`, `_mother_nid_image`, `_birth_certificate`, `_transfer_certificate`, `_testimonial`, `_academic_certificate`, `_marksheet`, `_student_photo`, `_adminssion_fee_amount`, `_monthly_fee`, `_resedential_type`, `_parents_signature`, `_main_subjects`, `_optional_subjects`, `_detail`, `_user_id`, `_user_name`, `_status`, `_lock`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(90, 73, 1, 1, 49, 55, 3, '2024-12-12', 1, 4, 5, 5, '03', NULL, 'Mst. Samia Khatun', 'মোছাঃ সামিয়া খাতুন ', '1', NULL, 'Female', 'mst.samiakhatun@gmail.com.1@gmail.com', '0000-00-00', '20184114741065415', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ জিল্লুর রহমান ', 'Md. Zillur Rahman', 'Driver', '100000', NULL, '149984531', NULL, 'Saleha Khatun', 'সালেহা খাতুন ', 'Housewife', '01975-117191', NULL, '1949766412', NULL, 'Saleha Khatun', NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', '01975-117191', '1949766412', NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(91, 74, 1, 1, 49, 56, 7, '2024-12-24', 1, 4, 5, 5, '07', NULL, 'Mst. Suraiya Khatun', 'মোছাঃ সুরাইয়া খাতুন ', '1', NULL, 'Female', 'mst.suraiyakhatun@gmail.com', '0000-00-00', '20154114741062417', NULL, NULL, '9', 'Bangladeshi', NULL, NULL, 'মোঃ মুকুল ', 'Md. Mukul ', 'Van Driver', NULL, '01400-094725', '7775340867', NULL, 'Mst. Nasima Khatun', 'মোছাঃ নাসিমা খাতুন ', 'Housewife', NULL, NULL, '4649675321', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(92, 75, 1, 1, 49, 57, 6, '2024-12-21', 1, 4, 5, 5, '06', NULL, 'Md. Siyam Molla', 'মোঃ সিয়াম মোল্যা ', '1', NULL, 'Male', 'md.siyammolla@gmail.com', '0000-00-00', '20204114741079906', NULL, NULL, '4', 'Bangladeshi', NULL, NULL, 'সাহাবুদ্দিন মোল্যা ', 'Shabuddin Molla', 'Farmer', NULL, '01775-450709', NULL, NULL, 'Chumki Parven', 'চুমকি পারভীন ', 'Housewife', NULL, NULL, '6473651229', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(93, 76, 1, 1, 49, 58, 5, '2024-12-15', 1, 4, 5, 5, '05', NULL, 'Md. Khalid Bin Walid Yeamin', 'মোঃ খালিদ বিন ওয়ালিদ ইয়ামিন ', '1', NULL, 'Male', 'md.khalidbinwalidyeamin@gmail.com', '0000-00-00', '20204121601356312', NULL, NULL, '4', 'Bangladeshi', NULL, NULL, 'মোঃ শফিকুল ইসলাম লাবলু ', 'Md. Shafikul Islam Lovelu', 'IT Job-holder', '100000', '01325-081308', '5528364184', NULL, 'Mst. Ashia Khatun', 'মোছাঃ আছিয়া খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(94, 77, 1, 1, 49, 59, 2, '2024-12-09', 1, 4, 5, 5, '02', NULL, 'Rafin Hasan', 'রাফিন হাসান ', '1', NULL, 'Male', 'rafinhasan@gmail.com', '0000-00-00', '20194114771035056', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'আকবার আলী ', 'Akbar Ali', 'Non-Resident', '60000', '01990-312944', '1024860932', NULL, 'Nazmin Akter ', 'নাজমিন আক্তার ', 'Housewife', NULL, NULL, '2693623605070', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(95, 78, 1, 1, 49, 60, 11, '2025-01-06', 1, 4, 5, 5, '11', NULL, 'Md. Sohaib Ansari', 'মোঃ সোহাইব আনছারী ', '1', NULL, 'Male', 'md.sohaibansari@gmail.com', '0000-00-00', NULL, NULL, NULL, '4', 'Bangladeshi', NULL, NULL, 'মোঃ দাউদ হোসেন ', 'Md. Dawood Hossain', 'Farmer', NULL, '01717-25164', NULL, NULL, 'Rekha', 'রেখা ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(96, 79, 1, 1, 49, 61, 12, '2025-01-07', 1, 4, 5, 5, '12', NULL, 'Tasin Hasan Ahad', 'তাছিন হাচান আহাদ ', '1', NULL, 'Male', 'tasinhasanahad@gmail.com', '0000-00-00', '20204114741073194', NULL, NULL, '4', 'Bangladeshi', NULL, NULL, 'মোঃ জাহিদুল ইসলাম ', 'Md. Zahidul Islam', 'Farmer', NULL, NULL, '2849727595', NULL, 'Morjina Akter', 'মর্জিনা আক্তার', 'Housewife', NULL, NULL, '7349723572', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(97, 80, 1, 1, 49, 62, 14, '2025-01-11', 1, 4, 5, 5, '14', NULL, 'Mst. Jannati Khatun', 'মোছাঃ জান্নাতি খাতুন ', '1', NULL, 'Female', 'mst.jannatikhatun@gmail.com', '0000-00-00', '20214114741073118', NULL, NULL, '3', 'Bangladeshi', NULL, NULL, 'শিমুল মোল্ল্যা ', 'Simul Molla', 'Mill Worker', NULL, NULL, '2854985849', NULL, 'Mst. Rupashi Khatun', 'মোছাঃ রুপাশী খাতুন ', 'Housewife', NULL, NULL, '5122402729', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(98, 81, 1, 1, 49, 63, 16, '2025-01-14', 1, 4, 5, 5, '16', NULL, 'Raisa Akhter Roza', 'রায়সা আক্তার রোজা ', '1', NULL, 'Female', 'raisaakhterroza@gmail.com', '0000-00-00', '20204114741065730', NULL, NULL, '4', 'Bangladeshi', NULL, NULL, 'মোঃ বিল্লাল হোসেন ', 'Md. Billal Hossain', 'Fisherman', NULL, '017060-76991', '6002826326', NULL, 'Rahima Khatun', 'রাহিমা খাতুন ', 'Housewife', NULL, NULL, '7824008366', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(99, 82, 1, 1, 49, 64, 10, '2025-01-04', 1, 4, 5, 5, '10', NULL, 'Mst. Saima Khatun', 'মোছাঃ সায়মা খাতুন ', '1', NULL, 'Female', 'mst.saimakhatun@gmail.com', '0000-00-00', NULL, NULL, NULL, '3', 'Bangladeshi', NULL, NULL, 'মোঃ সাগর হোসেন ', 'Md. Sagor Hossain', 'Businessman', NULL, '01990-836896', '1007934084', NULL, 'Julia Khatun', 'জুলিয়া খাতুন ', 'Housewife', NULL, NULL, '8262766010', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(100, 83, 1, 1, 49, 65, 17, '2024-01-20', 1, 4, 5, 5, '17', NULL, 'Mst. Rusa Khatun', 'মোছাঃ রুসা খাতুন ', '1', NULL, 'Female', 'mst.rusakhatun@gmail.com', '0000-00-00', NULL, NULL, NULL, '4', 'Bangladeshi', NULL, NULL, 'মোঃ রমজান আলী ', 'Md. Ramzan Ali', 'Businessman', NULL, '01622-427166', '8699729938', NULL, 'Mst. Rupali Khatun', 'মোছাঃ রূপালী খাতুন ', 'Housewife', NULL, NULL, '9155068464', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(101, 84, 1, 1, 49, 66, 4, '2024-12-15', 1, 4, 5, 5, '04', NULL, 'Elma Khatun', 'ইলমা খাতুন ', '1', NULL, 'Female', 'elmakhatun@gmail.com', '0000-00-00', '20184114741079916', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ ইয়াছিন আলী ', 'Md. Yeasin Ali', 'Businessman', NULL, NULL, '1024852681', NULL, 'Mst. Sabina Begum', 'মোছাঃ ছাবিনা বেগম ', 'Housewife', NULL, NULL, '2849661943', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(102, 85, 1, 1, 49, 67, 8, '2024-02-24', 1, 4, 5, 5, '08', NULL, 'Hriday Hossain', 'হৃদয় হোসেন ', '1', NULL, 'Male', 'hridayhossain@gmail.com', '0000-00-00', '20194114741070366', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ মুকুল ', 'Md. Mukul ', 'Van Driver', NULL, '01400-094725', '7775340867', NULL, 'Mst. Nasima Khatun', 'মোছাঃ নাসিমা খাতুন ', 'Housewife', NULL, NULL, '4649675321', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(103, 86, 1, 1, 49, 68, 13, '2023-12-20', 1, 4, 5, 5, '13', NULL, 'Litun Jira', 'লিতুন জিরা ', '1', NULL, 'Female', 'litunjira@gmail.com', '0000-00-00', NULL, NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ বাবুল হোসেন ', 'Md. Babul Hossain', 'Farmer', NULL, '01934-266317', '3305018941', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(104, 87, 1, 1, 49, 69, 9, '2024-01-31', 1, 4, 5, 5, '09', NULL, 'Mst. Humayra Khatun Johani', 'মোছাঃ হুমাইরা খাতুন জোহানী ', '1', NULL, 'Female', 'mst.humayrakhatunjohani@gmail.com', '0000-00-00', '20204114741069863', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ মাহাবুর রহমান', 'Md. Mahabur Rahaman', 'Farmer', NULL, '01913-492968', '4199629652', NULL, 'Ruma Begum Kulsum', 'রুমা বেগম কুলসুম', 'Housewife', NULL, NULL, '6904991111', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(105, 88, 1, 1, 49, 70, 18, '2025-04-09', 1, 4, 5, 5, '18', NULL, 'Afrin', 'আফরিন ', '1', NULL, 'Female', 'afrin@gmail.com', '0000-00-00', NULL, NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ মোক্তার হোসেন ', 'Md. Mokther Hossen', 'Court Clerk', '100000', '01905-615036', '5549728946', NULL, 'Saila Khatun', 'সায়লা খাতুন ', 'Housewife', NULL, NULL, '5552815457', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(106, 89, 1, 1, 49, 71, 1, '2025-01-02', 1, 4, 5, 5, '01', NULL, 'Amir Hamza', 'মোঃ আমির হামজা ', '1', NULL, 'Male', 'amirhamza@gmail.com', '0000-00-00', '20194114741066338', NULL, NULL, '3', 'Bangladeshi', NULL, NULL, 'মোঃ ইসমাইল হোসেন', 'Md. Ismile Hossin', 'Job-holder', '100000', '01910-304235', '2399675137', NULL, 'Sherina Akther', 'শিরিনা আক্তার ', 'Housewife', NULL, NULL, '9552669690', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(107, 90, 1, 1, 49, 72, 15, '2025-01-13', 1, 4, 5, 5, '15', NULL, 'Al-Alim', 'আল-আলিম', '1', NULL, 'Male', 'al-alim@gmail.com', '0000-00-00', '20204114741075000', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ জিহাদ হোসেন ', 'Md. Jihad Hossain', 'Mill Worker', '100000', '01920-777526', '1033182858', NULL, 'Mst. Sumaiya Khatu', 'মোছাঃ সুমাইয়া খাতুন ', 'Housewife', NULL, NULL, '6489269848', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(108, 91, 1, 1, 49, 73, 1, '2024-01-10', 1, 4, 6, 6, '01', NULL, 'Mohammad Ullah', 'মোহাম্মদ উল্লাহ ', '1', NULL, 'Male', 'mohammadullah@gmail.com', '0000-00-00', NULL, NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ জাহিদ খাঁন ', 'Md. Zahid Khan ', 'Businessman', NULL, '01717-726047', '1949614604', NULL, 'Mst. Najma Khatun Poli', 'মোছাঃ নাজমা খাতুন পলি ', 'Housewife', NULL, NULL, '2849537846', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: baliadanga, bscic baliadanga, Po: Jashore 7400, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(109, 92, 1, 1, 49, 74, 2, '2023-12-21', 1, 4, 6, 6, '02', NULL, 'Sifat Bin Sofik', 'সিফাত বিন শফিক', '1', NULL, 'Male', 'sifatbinsofik@gmail.com', '0000-00-00', '20184114783562348', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ শফিকুল ইসলাম', 'Md. Sofikul Islam', NULL, NULL, '01918-013897', '4199413651', NULL, 'Sarmin Akter', 'শারমিন আক্তার', 'Housewife', NULL, NULL, '5555043123', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Narendrapur, Po: Narendrapur, Jashore Sadar, Jashore. ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(110, 93, 1, 1, 49, 75, 3, '2023-12-10', 1, 4, 6, 6, '03', NULL, 'Aysha Khatun', 'আয়শা খাতুন ', '1', NULL, 'Female', 'ayshakhatun@gmail.com', '0000-00-00', '20184114741069079', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'তাবিবাররহমান ফজলে করিম\n', 'Tabibarrahman Fazle Karim', NULL, NULL, '01407-209141', NULL, NULL, 'Roksana Khatun ', 'রোকসানা খাতুন', 'Housewife', NULL, NULL, '6899613175', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(111, 94, 1, 1, 49, 76, 4, '2023-12-01', 1, 4, 6, 6, '04', NULL, 'Safia Akter Sohi', 'সাফিয়া আক্তার শশী ', '1', NULL, 'Female', 'safiaaktersohi@gmail.com', '0000-00-00', '20194114741065196', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ সোহেল রানা ', 'Md. Shohel Rana', 'Job-holder', NULL, '01738-414279', '4623590975', NULL, 'Sima Khatun', 'সিমা খাতুন ', 'Housewife', NULL, NULL, '3305027645', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(112, 95, 1, 1, 49, 77, 5, '2024-01-01', 1, 4, 6, 6, '05', NULL, 'Fatama Akter Anisha', 'ফাতেমা আক্তার আনিশা', '1', NULL, 'Female', 'fatamaakteranisha@gmail.com', '0000-00-00', NULL, NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ আরিফ হোসেন', 'Md. Arif Hossain', 'Job-holder', NULL, '01921-711051', '8699612712', NULL, 'Banani Khatun', 'বনানী খাতুন\n', 'Housewife', NULL, NULL, '19946517694000013', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(113, 96, 1, 1, 49, 78, 7, '2024-01-04', 1, 4, 6, 6, '07', NULL, 'Zannati Khatun', 'জান্নাতি খাতুন', '1', NULL, 'Female', 'zannatikhatun@gmail.com', '0000-00-00', '20174114741062739', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ শামীম হোসেন', 'Md. Shamim Hossan', 'Mason', NULL, '01977-855347', '1505044907', NULL, 'Hashima Khatun', 'হাসিমা খাতুন ', 'Housewife', NULL, NULL, '19914111723000315', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(114, 97, 1, 1, 49, 79, 8, '2013-12-01', 1, 4, 6, 6, '08', NULL, 'Tazmir hossen', 'তাজমির হোসেন', '1', NULL, 'Male', 'tazmirhossen@gmail.com', '0000-00-00', '20194114741069116', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ তৌহিদুল বিশ্বাস', 'Md. Tohidul Bisas', 'Farmer', NULL, '01921-615049', '5958626227', NULL, 'Mst. Ambia Khatun', 'মোছাঃ আম্বিয়া খাতুন', 'Housewife', NULL, NULL, '7304513356', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(115, 98, 1, 1, 49, 80, 9, '2026-12-23', 1, 4, 6, 6, '09', NULL, 'Md. Shahed Hossan', 'মোঃ সাহেদ হোসেন ', '1', NULL, 'Male', 'md.shahedhossan@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Bangladeshi', NULL, NULL, 'মিটুল হোসেন ', 'Mitul Hossin', 'Businessman', NULL, '01711-958155', '8699795236', NULL, 'Sahinur Begum', 'সাহিনুর বেগম', 'Housewife', NULL, NULL, '4649779750', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(116, 99, 1, 1, 49, 81, 10, '2024-12-31', 1, 4, 6, 6, '10', NULL, 'Mst. Jannatul Khatun', 'মোছাঃ জান্নাতুল খাতুন', '1', NULL, 'Female', 'mst.jannatulkhatun@gmail.com', '0000-00-00', NULL, NULL, NULL, '8', 'Bangladeshi', NULL, NULL, 'মোঃ ইকবাল হোসেন', 'Md. Iqbal Hossain', 'Businessman', NULL, NULL, '8699756642', NULL, 'Marufa Begum', 'মারুফা বেগম', 'Housewife', NULL, NULL, '4202735660', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(117, 100, 1, 1, 49, 82, 11, '2023-12-03', 1, 4, 6, 6, '11', NULL, 'Ayeat Islam', 'আয়াত ইসলাম', '1', NULL, 'Female', 'ayeatislam@gmail.com', '0000-00-00', NULL, NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'শরিফুল ইসলাম', 'Shariful Islam', 'Non-Resident', NULL, '01404-375958', NULL, NULL, 'Yeasmin Ara', 'ইয়াসমিন আরা', 'Housewife', NULL, NULL, '4174254914', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(118, 101, 1, 1, 49, 83, 12, '2024-01-04', 1, 4, 6, 6, '12', NULL, 'Mohsina Mariam', 'মোহসিনা মারিয়াম ', '1', NULL, 'Female', 'mohsinamariam@gmail.com', '0000-00-00', NULL, NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ আব্দুল্লাহ ', 'Md. Abdullah', 'Job-holder', NULL, '01920-280719', NULL, NULL, 'Muslima Sultana ', 'মুসলিমা সুলতানা', 'Housewife', NULL, NULL, '6449554598', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: khulchi, Po: Bagherpara, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(119, 102, 1, 1, 49, 84, 13, '2023-12-19', 1, 4, 6, 6, '13', NULL, 'Mst. Maliha Jannat', 'মোছাঃমালিহা জান্নাত', '1', NULL, 'Female', 'mst.malihajannat@gmail.com', '0000-00-00', '20184114741075771', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ সেলিম মোল্যা ', 'Md. Selim Molla', 'Rickshaw driver', NULL, NULL, '9149611130', NULL, 'Mst. Rosena', 'মোছাঃ রোজিনা ', 'Housewife', NULL, NULL, '9149609985', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', 'Fatehpur Govt. Primary School', 'Class One', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(120, 103, 1, 1, 49, 85, 14, '2023-12-25', 1, 4, 6, 6, '14', NULL, 'Rafid Hossen', 'রাফিদ হোসেন', '1', NULL, 'Male', 'rafidhossen@gmail.com', '0000-00-00', '20184114741072736', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ ফরহাদ হোসেন', 'Md. Farhad Hossain', 'Driver', NULL, '01997-353468', '1949700841', NULL, 'Salina Khatun', 'সেলিনা খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(121, 104, 1, 1, 49, 86, 15, '2023-12-28', 1, 4, 6, 6, '15', NULL, 'Md. Sajjad Hossain', 'মোঃ সাজ্জাদ হোসেন', '1', NULL, 'Male', 'md.sajjadhossain@gmail.com', '0000-00-00', '20194114741068244', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ জসীম  উদ্দিন', 'Md. Jashim Uddin ', 'Mechanic', NULL, '01912-996151', '1949765760', NULL, 'Mst. Mohua Khatun', 'মোছাঃ মহুয়া খাতুন', 'Housewife', NULL, NULL, '8706152777', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(122, 105, 1, 1, 49, 87, 16, '2024-01-13', 1, 4, 6, 6, '16', NULL, 'Md. Sazim Hossen', 'মোঃ সাজিম হোসেন', '1', NULL, 'Male', 'md.sazimhossen@gmail.com', '0000-00-00', '20204110928108947', NULL, NULL, '4', 'Bangladeshi', NULL, NULL, 'সুলায়মান হুসাইন ', 'Salaiman Hossain', 'Job-holder', NULL, '01925-545315', '7311419522', NULL, 'Ruma Khanom', 'রুমা খানম', 'Housewife', NULL, NULL, '9162935572', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Darajhat, Po: Chhatiantala, Bagharpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Darajhat, Po: Chhatiantala, Bagharpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(123, 106, 1, 1, 49, 88, 17, '2023-12-27', 1, 4, 6, 6, '17', NULL, 'Md. Siyam Hossen', 'মোঃ সিয়াম হোসেন', '1', NULL, 'Male', 'md.siyamhossen@gmail.com', '0000-00-00', '20154114741069164', NULL, NULL, '9', 'Bangladeshi', NULL, NULL, 'মোঃ কামরুজ্জামান', 'Md. Kamrujjaman', 'Farmer', NULL, NULL, NULL, NULL, 'Mst. Mukta Khatun', 'মোছাঃ মুক্তা খাতুন', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', 'Fatehpur Govt. Primary School', 'Class One', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(124, 107, 1, 1, 49, 89, 18, '2023-12-12', 1, 4, 6, 6, '18', NULL, 'Mst. Khadija Khatun', 'মোছাঃ খাদিজা খাতুন', '1', NULL, 'Female', 'mst.khadijakhatun@gmail.com', '0000-00-00', '20184114741074197', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'ওসমান আলী', 'Oasman Ali', 'Farmer', NULL, NULL, '1956298614', NULL, 'Mst. Rakha Khtun', 'মোছাঃ রেখা খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(125, 108, 1, 1, 49, 90, 19, '2023-12-26', 1, 4, 6, 6, '19', NULL, 'Ashmatulya Hussain', 'অছমতুল্যা হুসাইন ', '1', NULL, 'Male', 'ashmatulyahussain@gmail.com', '0000-00-00', '20194114741067280', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ সবুর হোসেন', 'Md. Sabur Hossain', 'Farmer', NULL, '01942-031329', '4199630064', NULL, 'Mst. Lucky Begum', 'মোছাঃ লাকি বেগম ', 'Housewife', NULL, NULL, '3749653576', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(126, 109, 1, 1, 49, 91, 20, '2024-01-25', 1, 4, 6, 6, '20', NULL, 'Abu Hussain Tamim', 'আবু হুসাইন  তামিম', '1', NULL, 'Male', 'abuhussaintamim@gmail.com', '0000-00-00', '20174114741075238', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মোঃ গোরাম কাদের ', 'Md. Golam Kadir', 'Farmer', NULL, '01972-790144', '2399639349', NULL, 'Asaia Khatun', 'আছিয়া খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', 'Daitala  Govt. Primary School', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(127, 110, 1, 1, 49, 92, 21, '2024-01-03', 1, 4, 6, 6, '21', NULL, 'Md. Jubayer Hossen', 'মোঃ জুবায়ের হোসেন', '1', NULL, 'Male', 'md.jubayerhossen@gmail.com', '0000-00-00', '20194114741075051', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'সোহেল  রানা ', 'Shoel Rana ', 'Farmer', NULL, '01902-739552', '6462733129', NULL, 'Shapla Khatun', 'শাপলা খাতুন', 'Housewife', NULL, NULL, '6473651138', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(128, 111, 1, 1, 49, 93, 22, '2023-12-12', 1, 4, 6, 6, '22', NULL, 'Tasnim Khatun', 'তাসনিম খাতুন', '1', NULL, 'Female', 'tasnimkhatun@gmail.com', '0000-00-00', '20184114771033143', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'রানা হোসেন', 'Rana Hossan', 'Businessman', NULL, '01911-608493', '4649763085', NULL, 'Mst. Shanta Begum', 'মোছাঃ শান্তা বেগম', 'Housewife', NULL, NULL, '2863030298', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(129, 112, 1, 1, 49, 94, 23, '2024-01-27', 1, 4, 6, 6, '23', NULL, 'Mst. Homaira Khatun', 'মোছাঃ হুমায়রা  খাতুন', '1', NULL, 'Female', 'mst.homairakhatun@gmail.com', '0000-00-00', NULL, NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ আবুল কালাম মোল্যা ', 'Md. Abul Kalam molla', 'Van Driver', NULL, NULL, '4199698483', NULL, 'Mst. Adori Begum', 'মোছাঃ আদরী বেগম ', 'Housewife', NULL, NULL, '5549415601', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(130, 113, 1, 1, 49, 95, 24, '2024-01-17', 1, 4, 6, 6, '24', NULL, 'Mst. Jacia Khatun ', 'মোছাঃ জেসিয়া খাতুন ', '1', NULL, 'Female', 'mst.jaciakhatun@gmail.com', '0000-00-00', '20194114741066006', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ ইমামুল হক', 'Md. Imamul Haque', 'Farmer', NULL, NULL, '5099624727', NULL, 'Mst. Jumur Khatun', 'মোছাঃ ঝুমুর খাতুন ', 'Housewife', NULL, NULL, '9152783396', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(131, 114, 1, 1, 49, 96, 25, '2024-02-24', 1, 4, 6, 6, '25', NULL, 'Roshan azam', 'রোশান আযম ', '1', NULL, 'Male', 'roshanazam@gmail.com', '0000-00-00', '20214114735064305', NULL, NULL, '4', 'Bangladeshi', NULL, NULL, 'মোঃ গোলাম আযম ', 'Md. Golam Azam', NULL, NULL, '01928-848530', '6462381424', NULL, 'Rikta Khatun', 'রিক্তা খাতুন', 'Housewife', NULL, NULL, '7795205033', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Damudia, Po: Dewara, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Damudia, Po: Dewara, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(132, 115, 1, 1, 49, 97, 26, '2024-12-09', 1, 4, 6, 6, '26', NULL, 'Ajmain Hasan Rijvi', 'আজমাইন হাসান রিজভী ', '1', NULL, 'Male', 'ajmainhasanrijvi@gmail.com', '0000-00-00', '20184114747064280', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ আনোয়ার জাহিদ', 'Md. Anwar Zahid', NULL, NULL, '01959-820232', '1916250648', NULL, 'Rubina Rervin Runa', 'রুবিনা পারভীন রুনা ', 'Housewife', NULL, NULL, '2412473957', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', 'Nure Madina Qumi Mohila Madrasha', 'Shishu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(133, 116, 1, 1, 49, 98, 27, '2024-12-10', 1, 4, 6, 6, '27', NULL, 'Md. Mustakim Hossain', 'মোঃ মুস্তাকিম হোসেন', '1', NULL, 'Male', 'md.mustakimhossain@gmail.com', '0000-00-00', '20184114741076774', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ মুকুল হোসেন', 'Md. Mukul Hossain', 'Carpenter', NULL, '01953-722744', '8715300813', NULL, 'Mim ', 'মিম', 'Housewife', NULL, NULL, '1512751247', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(134, 117, 1, 1, 49, 99, 28, '2024-12-24', 1, 4, 6, 6, '28', NULL, 'Mst. Sumaiya Khatun', 'মোছাঃ সুমাইয়া খাতুন ', '1', NULL, 'Female', 'mst.sumaiyakhatun@gmail.com', '0000-00-00', '20134114741062418', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'মোঃ মুকুল ', 'Md. Mukul ', 'Van Driver', NULL, '01400-094725', '7775340867', NULL, 'Mst. Nasima Khatun', 'মোছাঃ নাসিমা খাতুন ', 'Housewife', NULL, NULL, '4649675321', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(135, 118, 1, 1, 49, 100, 31, '2024-02-17', 1, 4, 6, 6, '31', NULL, 'Arisha Akhtar', 'আরিশা আক্তার ', '1', NULL, 'Female', 'arishaakhtar@gmail.com', '0000-00-00', '20184114741065197', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ আক্তার হোসেন ', 'Md. Akthar Hossen', NULL, NULL, '01939-375999', '9149611171', NULL, 'Rima Khatun', 'রিমা খাতুন', 'Housewife', NULL, NULL, '1513015451', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(136, 119, 1, 1, 49, 101, 32, '2025-04-19', 1, 4, 6, 6, '32', NULL, 'Md. Tamim Hasan', 'মোঃ তামিম হাসান ', '1', NULL, 'Male', 'md.tamimhasan@gmail.com', '0000-00-00', '20174114741069128', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মোঃ আছাদ  হোসেন', 'Md. Ashad Hossain', 'Farmer', '60000', '01956-272650', '1956272650', NULL, 'Mst. Keya Akther ', 'মোছাঃ কেয়া আক্তার', 'Housewife', NULL, NULL, '9578240591', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(137, 120, 1, 1, 49, 102, 30, '2025-01-04', 1, 4, 6, 6, '30', NULL, 'Md. Amanullah', 'মোঃ আমানউল্লাহ ', '1', NULL, 'Male', 'md.amanullah@gmail.com', '0000-00-00', '20174114741069823', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মোঃ আনোয়ারুল ইসলাম', 'Md. Anoyarul Islam', 'Non-Resident', '100000.00', '01972-790158', '6404505973', NULL, 'Mst. Rokaiya Khatun', 'মোছাঃ রোকাইয়া খাতুন', 'Housewife', NULL, NULL, '6906280190', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(138, 121, 1, 1, 49, 103, 29, '2025-01-02', 1, 4, 6, 6, '29', NULL, 'Riyadh', 'রিয়াদ ', '1', NULL, 'Male', 'riyadh@gmail.com', '0000-00-00', NULL, NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মোঃ মাহাবুব', 'Md. Mahabub ', ' Driver', NULL, '01924-225898', '1949700296', NULL, 'Marufa Begum', 'মারুফা বেগম', 'Housewife', NULL, NULL, '6012752348', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(139, 122, 1, 1, 49, 104, 6, '2024-03-06', 1, 4, 6, 6, '06', NULL, 'Tachin Ahmed', 'তাছিন আহম্মেদ ', '1', NULL, 'Male', 'tachinahmed@gmail.com', '0000-00-00', NULL, NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ মতিয়ার  মোল্যা ', 'Md. Matiar Mollah', 'Farmer', NULL, '01931-369093', NULL, NULL, 'Mst. Jinnat Ara', 'মোছাঃ জিন্নাত আরা ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(140, 123, 1, 1, 49, 105, 1, '2023-12-23', 1, 4, 8, 8, '01', NULL, 'Abrar Fahim', 'আবরার ফাহিম', '1', NULL, 'Male', 'abrarfahim@gmail.com', '0000-00-00', '20184114741064482', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ সাজল হোসেন', 'Md. Sazol Hossain', 'Job-holder', NULL, '01854-426578', '8661025465', NULL, 'Umme Hafsa', 'উম্মে হাফসা', 'Housewife', NULL, NULL, '6402011321', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(141, 124, 1, 1, 49, 106, 2, '2023-12-06', 1, 4, 8, 8, '02', NULL, 'Md. Billal Hosen', 'মোঃ বিল্লাল হোসেন', '1', NULL, 'Male', 'md.billalhosen@gmail.com', '0000-00-00', '20144114741069864', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'মোঃ মাহাবুর রহমান', 'Md. Mahabur Rahaman', 'Farmer', NULL, '01913-492968', '4199629652', NULL, 'Ruma Begum Kulsum', 'রুমা বেগম কুলসুম', 'Housewife', NULL, NULL, '6904991111', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(142, 125, 1, 1, 49, 107, 3, '2023-12-02', 1, 4, 8, 8, '03', NULL, 'Mst. Tabassum Khatun', 'মোছাঃ তাবাচ্ছুম খাতুন ', '1', NULL, 'Female', 'mst.tabassumkhatun@gmail.com', '0000-00-00', '20174114741071349', NULL, NULL, '8', 'Bangladeshi', NULL, NULL, 'মোঃ তুহিন হোসেন', 'Md. Tuhin Hossain', 'Farmer', NULL, '01933-266633', '1502735614', NULL, 'Tanjira Khatun', 'তানজিরা খাতুন', 'Housewife', NULL, NULL, '3754058075', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(143, 126, 1, 1, 49, 108, 4, '2023-12-02', 1, 4, 8, 8, '04', NULL, 'Maimun Jubayer', 'মাইমুন জুবায়ের', '1', NULL, 'Male', 'maimunjubayer@gmail.com', '0000-00-00', '20174114741070579', NULL, NULL, '8', 'Bangladeshi', NULL, NULL, 'মোঃ বাবলু হোসেন', 'Md. Bablu Hossain', 'Job-holder', NULL, '01416-872855', '3749720508', NULL, 'Kameni Sultana', 'কামিনী সুলতানা ', 'Housewife', NULL, NULL, '1023997214', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(144, 127, 1, 1, 49, 109, 5, '2024-01-31', 1, 4, 8, 8, '05', NULL, 'Lamia Min Samia', 'লামিয়া মিন  সামিয়া ', '1', NULL, 'Female', 'lamiaminsamia@gmail.com', '0000-00-00', '20174114741075429', NULL, NULL, '8', 'Bangladeshi', NULL, NULL, 'জি. এম. ইনামুল হাসান মনি', 'G. M. Inamul Hasan Mony', 'Mason', NULL, '01927-401510', '1949804130', NULL, 'Mariam Khatun', 'মরিয়াম খাতুন ', 'Housewife', NULL, NULL, '5552813049', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(145, 128, 1, 1, 49, 110, 6, '2023-12-24', 1, 4, 8, 8, '06', NULL, 'Mst. Samiya Akter', 'মোছাঃ সামিয়া আক্তার', '1', NULL, 'Female', 'mst.samiyaakter@gmail.com', '0000-00-00', '20174114741075907', NULL, NULL, '8', 'Bangladeshi', NULL, NULL, 'মোঃ হাবিবুর রহমান', 'Md. Habibur Rahman', 'Farmer', NULL, NULL, '5549778131', NULL, 'Akhinur Begum', 'আখিনুর বেগম', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(146, 129, 1, 1, 49, 111, 7, '2024-01-01', 1, 4, 8, 8, '07', NULL, 'Md. Imtiaz Hossain Imu', 'মোঃ ইমতিয়াজ হোসেন ইমু', '1', NULL, 'Male', 'md.imtiazhossainimu@gmail.com', '0000-00-00', '20184114741074319', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'ইলিয়াস হোসেন', 'Elias Hossain', ' Driver', NULL, '01585-285206', '8699612753', NULL, 'Mousume Khatun', 'মৌসুমী খাতুন', 'Housewife', NULL, NULL, '8703147713', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(147, 130, 1, 1, 49, 112, 8, '2023-12-20', 1, 4, 8, 8, '08', NULL, 'Md. Ahnaf Abid', 'মোঃ আহনাফ আবিদ', '1', NULL, 'Male', 'md.ahnafabid@gmail.com', '0000-00-00', '20184114741075614', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ গোলাম কাদের', 'Md. Golam Kader', 'Businessman', NULL, '01952-128417', '1024814897', NULL, 'Pali Khatun', 'পলি খাতুন', 'Housewife', NULL, NULL, '9152792884', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(148, 131, 1, 1, 49, 113, 9, '2023-12-01', 1, 4, 8, 8, '09', NULL, 'Amatulla Tasnim Maroa', 'আমাতুল্লাহ তাসনীম মারওয়া ', '1', NULL, 'Female', 'amatullatasnimmaroa@gmail.com', '0000-00-00', '20184121605308901 ', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'মুহাম্মদ রুহুল কুদ্দুস ', 'Mohammad Ruhul Kuddus', 'Teacher', NULL, '01712-531022', '9112891743', NULL, 'Rabeya Mukta', 'রাবেয়া মুক্তা', 'Housewife', NULL, NULL, '9556437854', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '918 Arabpur, Po: Jashore Sadar 7400, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07');
INSERT INTO `stm_students` (`id`, `_user_table_id`, `organization_id`, `_branch_id`, `_account_group_id`, `_ledger_id`, `_roll_no`, `_admission_date`, `_admission_session_id`, `_education_type`, `_admission_class_id`, `_current_class_id`, `_student_id`, `_proximity_card_no`, `_name_in_english`, `_name_in_bangla`, `_religion`, `_student_image`, `_gender`, `_email`, `_date_of_birth`, `_barth_id`, `_bloodgroup`, `_s_identification_mark`, `_age`, `_nationality`, `_height`, `_weight`, `_father_name_bangla`, `_father_name_english`, `_occupation`, `_annual_income`, `_f_mobile_no`, `_f_nid_no`, `_f_email`, `_mother_name_english`, `_mother_name_of_bangla`, `_mother_occupation`, `_mother_mobile_no`, `_mother_anual_income`, `_mother_nid_no`, `_mother_email`, `_local_guardian_name`, `_local_guardian_occupation`, `_local_guardian_address`, `_local_guardian_mobile`, `_local_guardian_nid`, `_local_guardian_nid_image`, `_present_address`, `_per_country_id`, `_per_division_id`, `_per_district_id`, `_per_thana_id`, `_per_union_id`, `_cur_division_id`, `_cur_country_id`, `_cur_district_id`, `_cur_thana_id`, `_cur_union_id`, `_per_post_office`, `_cur_post_office`, `_parmanent_address`, `_previous_institute_name`, `_pre_class`, `_pre_result`, `_pre_roll_no`, `_father_nid_image`, `_mother_nid_image`, `_birth_certificate`, `_transfer_certificate`, `_testimonial`, `_academic_certificate`, `_marksheet`, `_student_photo`, `_adminssion_fee_amount`, `_monthly_fee`, `_resedential_type`, `_parents_signature`, `_main_subjects`, `_optional_subjects`, `_detail`, `_user_id`, `_user_name`, `_status`, `_lock`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(149, 132, 1, 1, 49, 114, 10, '2024-01-01', 1, 4, 8, 8, '10', NULL, 'Md. Abu Jorr', 'মোঃ আবু জ্বর ', '1', NULL, 'Male', 'md.abujorr@gmail.com', '0000-00-00', '20174114741075469', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'বিল্লাল হোসেন', 'Billal Hossen ', ' Driver', NULL, '01906-678848', '5562904796', NULL, 'Mst. Soniya Khatun', 'মোছাঃ সোনিয়া খাতুন', 'Housewife', NULL, NULL, '4212752325', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(150, 133, 1, 1, 49, 115, 12, '2023-12-25', 1, 4, 8, 8, '12', NULL, 'Taskin Hussain', 'তাসকিন হুসাইন ', '1', NULL, 'Male', 'taskinhussain@gmail.com', '0000-00-00', '20164114741072889', NULL, NULL, '8', 'Bangladeshi', NULL, NULL, 'মোঃ মানিক হোসেন', 'Md. Manik Hossen', 'Non-Resident', NULL, '01940-257072', '5549778206', NULL, 'Mst. Kakoli Begum', 'মোছাঃ কাকলী বেগম ', 'Housewife', NULL, NULL, '2804835185', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(151, 134, 1, 1, 49, 116, 13, '2023-12-20', 1, 4, 8, 8, '13', NULL, 'Md. Jayed Sabit', 'মোঃ যায়েদ সাবিত', '1', NULL, 'Male', 'md.jayedsabit@gmail.com', '0000-00-00', '20184114741075614', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ গোলাম কাদের', 'Md. Golam Kader', 'Businessman', NULL, '01952-128417', '1024814897', NULL, 'Pali Khatun', 'পলি খাতুন', 'Housewife', NULL, NULL, '9152792884', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(152, 135, 1, 1, 49, 117, 14, '2024-01-10', 1, 4, 8, 8, '14', NULL, 'Tasmin Nahar Sinthia', 'তাসমিন নাহার সিনথিয়া ', '1', NULL, 'Female', 'tasminnaharsinthia@gmail.com', '0000-00-00', '20184114741074911', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'রবিউল ইসলাম', 'Robiul Islam', ' Driver', NULL, '01933-259330', '2849622382', NULL, 'Hasina Begum', 'হাসিনা বেগম', 'Housewife', NULL, NULL, '5099585720', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(153, 136, 1, 1, 49, 118, 15, '2023-12-02', 1, 4, 8, 8, '15', NULL, 'Mst. Lamia Akter', 'মোছাঃ লামিয়া আক্তার', '1', NULL, 'Female', 'mst.lamiaakter@gmail.com', '0000-00-00', '20174114741069082', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মোঃ তারিকুল ইসলাম', 'Md. Tarikul Islam', 'Job-holder', NULL, '01927-802332', '2399674775', NULL, 'Mst. Moriam Begum', 'মোছাঃ মরিয়াম  বেগম', 'Housewife', NULL, NULL, '8706372326', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', 'Fatehpur Govt. Primary School', 'Shishu ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(154, 137, 1, 1, 49, 119, 16, '2023-12-04', 1, 4, 8, 8, '16', NULL, 'Mst. Aysha Seddika', 'মোছাঃ আয়শা সিদ্দিকা ', '1', NULL, 'Female', 'mst.ayshaseddika@gmail.com', '0000-00-00', '20184114741074608', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'মোঃ মনিরুজ্জামান জীবন ', 'Md. Moniruzzaman Jebon', 'Job-holder', NULL, '01957-611582', '1483145569', NULL, 'Ms. Rumicha Khatun', 'মোছাঃ রুমিচা খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, 'Play', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(155, 138, 1, 1, 49, 120, 17, '2024-01-13', 1, 4, 8, 8, '17', NULL, 'Md. Mustakim Hossen', 'মোঃ মুস্তাকিম হোসেন', '1', NULL, 'Male', 'md.mustakimhossen@gmail.com', '0000-00-00', '20184110928108936', NULL, NULL, '6', 'Bangladeshi', NULL, NULL, 'সুলায়মান হুসাইন ', 'Salaiman Hossain', NULL, NULL, '01925-545315', '7311419522', NULL, 'Ruma Khanom', 'রুমা খানম', 'Housewife', NULL, NULL, '9162935572', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Darajhat, Po: Chhatiantala, Bagharpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Darajhat, Po: Chhatiantala, Bagharpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(156, 139, 1, 1, 49, 121, 18, '2023-12-20', 1, 4, 8, 8, '18', NULL, 'Md. Muzahid Hossen', 'মোঃ মুজাহিদ হোসেন', '1', NULL, 'Male', 'md.muzahidhossen@gmail.com', '0000-00-00', '20194114741068771', NULL, NULL, '5', 'Bangladeshi', NULL, NULL, 'সালাহ উদ্দীন ', 'Salha Uddin', 'Job-holder', NULL, '01994-261849', '2849622168', NULL, 'Tania Khatun ', 'তানিয়া খাতুন', 'Housewife', NULL, NULL, '6899613662', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(157, 140, 1, 1, 49, 122, 19, '2024-12-28', 1, 4, 8, 8, '19', NULL, 'Md. Abdur Rahman', 'মোঃ আব্দুর রহমান', '1', NULL, 'Male', 'md.abdurrahman@gmail.com', '0000-00-00', '20174114741060349', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মোঃ ইসরাইল  হোসেন', 'Md. Israil Hossain', 'Businessman', NULL, '01710-832469', '7349645684', NULL, 'Mst. Feroza Sultana', 'মোছাঃ ফিরোজা সুলতানা', 'Housewife', NULL, NULL, '5549634896', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(158, 141, 1, 1, 49, 123, 20, '2025-01-25', 1, 4, 8, 8, '20', NULL, 'Mst. Mariam Khatun', 'মোছাঃ মরিয়াম খাতুন ', '1', NULL, 'Female', 'mst.mariamkhatun@gmail.com', '0000-00-00', NULL, NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মোঃ আব্দুল কাদের রায়হান', 'Md. Abdul Quader Raihan', NULL, NULL, NULL, NULL, NULL, 'Rabeya Khatun', 'রাবেয়া খাতুন', 'Housewife', NULL, NULL, '6902631016', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Amdanga, Po:Vangagate, Ovinagar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Amdanga, Po:Vangagate, Ovinagar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(159, 142, 1, 1, 49, 124, 21, '2025-03-02', 1, 4, 8, 8, '21', NULL, 'Nasim Hossen', 'নাছিম  হোসেন', '1', NULL, 'Male', 'nasimhossen@gmail.com', '0000-00-00', '20124110915102652', NULL, NULL, '13', 'Bangladeshi', NULL, NULL, 'মোঃ সোহাগ হোসেন ', 'Mst. Sohag Hossain', NULL, NULL, '01967-544546', NULL, NULL, 'Shewly Khatun', 'শিউলি খাতুন', 'Housewife', NULL, NULL, '7306993572', NULL, 'Md. Robuil Islam', NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', '01967-544546', NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Pakerali, Po: Charavita, Bagerpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(160, 143, 1, 1, 49, 125, 22, '2025-04-15', 1, 4, 8, 8, '22', NULL, 'Md. Hussain ', 'মোঃ হুসাইন ', '1', NULL, 'Male', 'md.hussain@gmail.com', '0000-00-00', '20174114771034210', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মোঃ জাহিদুল ইসলাম', 'Md. Jahidul Islam', 'Imam', NULL, '01940-206205', '8249662456', NULL, 'Some Khatun', 'সুমী খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(161, 144, 1, 1, 49, 126, 11, '2024-07-16', 1, 4, 8, 8, '11', NULL, 'Safia Khatun', 'সাফিয়া খাতুন', '1', NULL, 'Female', 'safiakhatun@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Bangladeshi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Md. Chanchal Ali Biswas', NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', '01941-973375', NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(162, 145, 1, 1, 49, 127, 3, '2024-01-01', 1, 4, 7, 7, '03', NULL, 'Mst. Eshita ', 'মোছাঃ ইশিতা ', '1', NULL, 'Female', 'mst.eshita@gmail.com', '0000-00-00', '20164114741059133', NULL, NULL, '9', 'Bangladeshi', NULL, NULL, 'মৃতঃ মোঃ ইলিয়াছ হোসেন ', 'Md. Elias Hossain', NULL, NULL, NULL, NULL, NULL, 'Mos. Mousumi Khatun', 'মোছাঃ মৌসুমী খাতুন', 'Housewife', '01405-223363', NULL, '1956439366', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(163, 146, 1, 1, 49, 128, 1, '2014-01-01', 1, 4, 7, 7, '01', NULL, 'Mst. Moriam Khatun', 'মোছাঃ মরিয়ম খাতুন', '1', NULL, 'Female', 'mst.moriamkhatun@gmail.com', '0000-00-00', '20184114711062120', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মৃতঃ মোঃ ইলিয়াছ হোসেন ', 'Md. Elias Hossain', NULL, NULL, NULL, NULL, NULL, 'Mos. Mousumi Khatun', 'মোছাঃ মৌসুমী খাতুন', 'Housewife', '01405-223363', NULL, '1956439366', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(164, 147, 1, 1, 49, 129, 4, '2023-12-16', 1, 4, 7, 7, '04', NULL, 'Jannatul Ferdous Toha', 'জান্নাতুল ফেরদৌস তোহা', '1', NULL, 'Female', 'jannatulferdoustoha@gmail.com', '0000-00-00', '20174114741066071', NULL, NULL, '8', 'Bangladeshi', NULL, NULL, 'মোঃ আব্বাস আলী', 'Md. Abbas Ali', NULL, NULL, NULL, '9574818309', NULL, 'Soina Akther Nepa', 'সোনিয়া আক্তার নিপা ', 'Housewife', NULL, NULL, '2939675319', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(165, 148, 1, 1, 49, 130, 2, '2023-12-16', 1, 4, 7, 7, '02', NULL, 'Mst. Mim Akter', 'মোছাঃ মীম আক্তার ', '1', NULL, 'Female', 'mst.mimakter@gmail.com', '0000-00-00', '20154114741066336', NULL, NULL, '9', 'Bangladeshi', NULL, NULL, 'মোঃ ইসমাইল হোসেন', 'Md. Ismile Hossin', 'Job-holder', '100000', '01910-304235', '2399675137', NULL, 'Sherina Akther', 'শিরিনা আক্তার ', 'Housewife', NULL, NULL, '9552669690', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', 'Fatehpur Govt. Primary School', 'Class One', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(166, 149, 1, 1, 49, 131, 10, '2024-01-31', 1, 4, 7, 7, '10', NULL, 'Mumtahina Mahmuda', 'মুমতাহিনা মাহমুদা', '1', NULL, 'Female', 'mumtahinamahmuda@gmail.com', '0000-00-00', '20174114741074959', NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মাওঃ মোঃ শরীফুল ইসলাম ', 'MOU. Md. Shariful Islam', 'Teacher', NULL, '01933-184236', '9149678808', NULL, 'Mohsina Yeasmin', 'মোহসেনা ইয়াসমিন ', 'Housewife', NULL, NULL, '3727659017', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', 'Fatehpur Govt. Primary School', 'Class One', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(167, 150, 1, 1, 49, 132, 11, '2023-12-24', 1, 4, 7, 7, '11', NULL, 'Md. Samiul Islam', 'মোঃ সামিউল ইসলাম', '1', NULL, 'Male', 'md.samiulislam@gmail.com', '0000-00-00', '20164114741071310', NULL, NULL, '8', 'Bangladeshi', NULL, NULL, 'সাজেদুল ইসলাম', 'Sazadul Islam Manik', 'Job-holder', NULL, '01868-587084', '9553660839', NULL, 'Mst. Labone Khatun', 'মোছাঃ লাবনী খাতুন ', 'Housewife', NULL, NULL, '6445238006', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(168, 151, 1, 1, 49, 133, 6, '2023-12-11', 1, 5, 7, 7, '06', NULL, 'Md. Abu Talha Rabby', 'মোঃ আবু তালহা রাব্বি', '1', NULL, 'Male', 'md.abutalharabby@gmail.com', '0000-00-00', '20154114765027984', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'মোঃ আবুল বাশার', 'Md. Abul Bashar', NULL, NULL, '01716-982749', '3298812102', NULL, 'Mst. Adori Khatun', 'মোছাঃ আদুরী খাতুন ', 'Housewife', NULL, NULL, '5552824939', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(169, 152, 1, 1, 49, 134, 13, '2025-01-22', 1, 5, 7, 7, '13', NULL, 'Md. Rafsan Hossain', 'মোঃ রাফছান হুসাইন ', '1', NULL, 'Male', 'md.rafsanhossain@gmail.com', '0000-00-00', '20154114765007517', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'মোঃ সোহেল রানা', 'Md. Shohel Rana', 'Non-Resident', NULL, '01757-954183', NULL, NULL, 'Khadija Khatun', 'খাদিজা খাতুন', 'Housewife', NULL, NULL, '1506149416', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Soroudanga, Po: Hasimpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Soroudanga, Po: Hasimpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(170, 153, 1, 1, 49, 135, 9, '2023-12-26', 1, 5, 7, 7, '09', NULL, 'Md. Jihad Hasan Chiku', 'মোঃ জিহাদ হাসান চিকু ', '1', NULL, 'Male', 'md.jihadhasanchiku@gmail.com', '0000-00-00', '20144114741062687', NULL, NULL, '11', 'Bangladeshi', NULL, NULL, 'মোঃ মাহাবুব', 'Md. Mahabub ', ' Driver', NULL, '01924-225898', '1949700296', NULL, 'Marufa Begum', 'মারুফা বেগম', 'Housewife', NULL, NULL, '6012752348', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(171, 154, 1, 1, 49, 136, 15, '2025-02-17', 1, 5, 7, 7, '15', NULL, 'Md. Jidni Hasan', 'মোঃ জিদনী হাসান ', '1', NULL, 'Male', 'md.jidnihasan@gmail.com', '0000-00-00', '20114114741062673', NULL, NULL, '13', 'Bangladeshi', NULL, NULL, 'মোঃ চঞ্চল আলী বিশ্বাস', 'Md. Chanchal Ali Biswas', 'Businessman', NULL, '01941-973375', NULL, NULL, 'Mst. Sabina Begum', 'মোছাঃ ছাবিনা বেগম ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(172, 155, 1, 1, 49, 137, 7, '2024-01-11', 1, 5, 7, 7, '07', NULL, 'Md. Sihab Uddin', 'মোঃ সিহাব উদ্দিন', '1', NULL, 'Male', 'md.sihabuddin@gmail.com', '0000-00-00', '20144111765037064', NULL, NULL, '11', 'Bangladeshi', NULL, NULL, 'মোঃ আব্দুল জুব্বার', 'Md. Abdul Jubbar', 'Job-holder', NULL, '01724-319865', '1923920977', NULL, 'Mst. Sheuli Begum', 'মোছাঃ শিউলি বেগম', 'Housewife', NULL, NULL, '8698851808', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(173, 156, 1, 1, 49, 138, 5, '2023-12-23', 1, 5, 7, 7, '05', NULL, 'Muttasin Islam Noman\n', 'মুত্তাসিন ইসলাম নোমান ', '1', NULL, 'Male', 'muttasinislamnoman\n@gmail.com', '0000-00-00', '20144114771027821', NULL, NULL, '9', 'Bangladeshi', NULL, NULL, 'রবিউল ইসলাম', 'Robiul Islam', 'Farmer', NULL, NULL, '4114771419164', NULL, 'Rojina Begum', 'রোজিনা বেগম', 'Housewife', NULL, NULL, '4114771419165', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Raimanik, Po: Kachua, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Raimanik, Po: Kachua, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(174, 157, 1, 1, 49, 139, 12, '1970-01-01', 1, 5, 7, 7, '12', NULL, 'Md. Alif Hasan Sawm', 'মোঃ আলিফ হাসান সাওম ', '1', NULL, 'Male', 'md.alifhasansawm@gmail.com', '0000-00-00', '20144114765018258', NULL, NULL, '11', 'Bangladeshi', NULL, NULL, 'মোঃ ওসমান গনি', 'Md. Osman Goni', NULL, NULL, '01739-105522', '5998631936', NULL, 'Mst. Shopna Begum', 'মোছাঃ স্বপনা বেগম ', 'Housewife', '01748-828510', NULL, '4198793533', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(175, 158, 1, 1, 49, 140, 14, '2025-01-05', 1, 5, 7, 7, '14', NULL, 'Md. Hossain', 'মোঃ হুসাইন ', '1', NULL, 'Male', 'md.hossain@gmail.com', '0000-00-00', '20134130947104792', NULL, NULL, '12', 'Bangladeshi', NULL, NULL, 'জসীম উদ্দিন ', 'Jashim Uddin', NULL, NULL, '01758-831127', '19884110947846473', NULL, 'Rozina Khatun', 'রোজিনা খাতুন', 'Housewife', NULL, NULL, '4110947846472', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Bahorampur, Po: Bahorampur, Bagerpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Bahorampur, Po: Bahorampur, Bagerpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(176, 159, 1, 1, 49, 141, 8, '2024-06-01', 1, 4, 7, 7, '08', NULL, 'Namia Akter Najifa', 'নাইমা আক্তার নাজিফা ', '1', NULL, 'Female', 'namiaakternajifa@gmail.com', '0000-00-00', '20164114741065021', NULL, NULL, '8', 'Bangladeshi', NULL, NULL, 'মোঃ আসাদুসুজ্জামান', 'Md. Asaduszzaman', NULL, NULL, NULL, NULL, NULL, 'Tania Khatun', 'তানিয়া খাতুন', 'Housewife', NULL, NULL, '9162766688', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Hamidpur, Po: Hamidpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 250, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '46', '46', '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(177, 164, 1, 1, 49, 156, 23, '2025-04-28', 1, 7, 10, 0, '1', '1', 'Md.Jubayet Hossen', 'মোঃ জুবায়েত হোসেন', '', NULL, 'Male', '', '2009-12-08', '20094114777021705', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0', 0, 0, 0, '0', 0, 0, 0, 0, '0', 0, '0', '0', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 600, 2500, '2', NULL, '', '', '', 49, 'Shihab', 1, 0, NULL, NULL, '2025-05-19 12:01:16', '2025-05-19 15:44:42'),
(178, 165, 1, 1, 49, 157, 23, '2025-04-22', 1, 6, 10, 10, '23', NULL, 'Tanveen Hassan Adar', 'তানভিন হাসান আদর', '1', NULL, 'Male', 'tanveenhassanadar@gmail.com', '0000-00-00', NULL, NULL, NULL, '7', 'Bangladeshi', NULL, NULL, 'মোঃ আক্কাস আলী ', 'Md. Akkus Ali', NULL, NULL, '01973-864371', '5999711863', NULL, 'Mst. Adori Khatun', 'মোছাঃ আদরী  খাতুন ', 'Housewife', NULL, NULL, '6469565128', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Chandpara, Po: Hamidpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Chandpara, Po: Hamidpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 2500, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(179, 166, 1, 1, 49, 158, 2, '2023-09-24', 1, 6, 10, 10, '02', NULL, 'Md. Easin Arafat', 'মোঃ ইয়াছিন আরাফাত ', '1', NULL, 'Male', 'md.easinarafat@gmail.com', '0000-00-00', '20104114765025515', NULL, NULL, '14', 'Bangladeshi', NULL, NULL, 'সাইফুল ইসলাম', 'Saiful Islam', NULL, NULL, '01704-795070', '2848720872', NULL, 'Hira Khatun', 'হীরা খাতুন', 'Housewife', NULL, NULL, '2848720492', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(180, 167, 1, 1, 49, 159, 4, '2024-05-04', 1, 6, 10, 10, '04', NULL, 'Huzaifa Jubayer', 'হুজাইফা জুবায়ের', '1', NULL, 'Male', 'huzaifajubayer@gmail.com', '0000-00-00', '20104114741057196', NULL, NULL, '14', 'Bangladeshi', NULL, NULL, 'মোঃ মোমিনুল ইসলাম', 'Md.Mominul Islam', NULL, NULL, '01813-562493', '9149677602', NULL, 'Rahima Begum', 'রহিমা বেগম', 'Housewife', NULL, NULL, '8658279941', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500.01, 1000, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(181, 168, 1, 1, 49, 160, 6, '2024-05-04', 1, 6, 10, 10, '06', NULL, 'Sabid Hasan', 'সাবিত হাসান ', '1', NULL, 'Male', 'sabidhasan@gmail.com', '0000-00-00', '20154114741057198', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'মোঃ মোমিনুল ইসলাম', 'Md.Mominul Islam', NULL, NULL, '01813-562493', '9149677602', NULL, 'Rahima Begum', 'রহিমা বেগম', 'Housewife', NULL, NULL, '8658279941', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500.01, 1000, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(182, 169, 1, 1, 49, 161, 7, '2024-12-22', 1, 6, 10, 10, '07', NULL, 'Fahim Foysal', 'ফাহিম ফয়সাল', '1', NULL, 'Male', 'fahimfoysal@gmail.com', '0000-00-00', '20124114765013611', NULL, NULL, '12', 'Bangladeshi', NULL, NULL, 'আজগর আলী', 'Azgor Ali ', NULL, NULL, '01713-915535', '1948859036', NULL, 'Mst. Afia Khatun', 'মোছাঃ আফিয়া খাতুন', 'Housewife', NULL, NULL, '2398834396', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(183, 170, 1, 1, 49, 162, 9, '2024-05-04', 1, 6, 10, 10, '09', NULL, 'Md. Aminur Rahaman', 'মোঃ আমিনুর রহমান', '1', NULL, 'Male', 'md.aminurrahaman@gmail.com', '0000-00-00', '20144114741062963', NULL, NULL, '11', 'Bangladeshi', NULL, NULL, 'সাইদুর রহমান', 'Saydur Rahman', NULL, NULL, '01926-234844', '2849662206', NULL, 'Hira Begum', 'হিরা বেগম ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(184, 171, 1, 1, 49, 163, 10, '2024-05-04', 1, 6, 10, 10, '10', NULL, 'Md.Ismail hossain.', 'মোঃ ইসমাইল হোসেন ', '1', NULL, 'Male', 'md.ismailhossain.@gmail.com', '0000-00-00', '20154114741068446', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'মোঃ মনিরুজ্জামান ', 'Md Moniruzzaman', NULL, NULL, '01982-447563', '2399741806', NULL, 'Mst.Hazera khatun', 'মোছাঃ হাজেরা খাতুন', 'Housewife', NULL, NULL, '7326253874', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(185, 172, 1, 1, 49, 164, 11, '2024-05-04', 1, 6, 10, 10, '11', NULL, 'Mohammad Ullah', 'মোহাম্মদ উল্লাহ', '1', NULL, 'Male', 'mohammadullah@gmail.com.1@gmail.com', '0000-00-00', '20144114741065268', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'আনিসুর রহমান', 'Anisur Rahaman', NULL, NULL, NULL, '3299572309', NULL, 'Fatema Khatun', 'ফাতেমা খাতুন', 'Housewife', NULL, NULL, '4652838246', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Daitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(186, 173, 1, 1, 49, 165, 13, '2023-12-31', 1, 6, 10, 10, '13', NULL, 'Zihad Islam', 'জিহাদ ইসলাম', '1', NULL, 'Male', 'zihadislam@gmail.com', '2004-09-20', '20124114771028997', NULL, NULL, '12', 'Bangladeshi', NULL, NULL, 'মোঃ ফিরোজ হোসেন', 'Md. Firoz Hossain', NULL, NULL, '01937-756622', '7324949838', NULL, 'Mst. Rahela Khatun', 'মোছাঃ রাহেলা খাতুন ', 'Housewife', NULL, NULL, '8244459726', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Raimanik, Po: Kachua, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Raimanik, Po: Kachua, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(187, 174, 1, 1, 49, 166, 15, '2004-05-24', 1, 6, 10, 10, '15', NULL, 'Md. Jihadul Islam Jihad', 'মোঃ জিহাদুল ইসলাম জিহাদ', '1', NULL, 'Male', 'md.jihadulislamjihad@gmail.com', '0000-00-00', '20144114741064877', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'মোঃ সামছুর রহমান ', 'Md. Shamsur Raman', NULL, NULL, '01920-756199', '1499644340', NULL, 'Mst. Moone Begum', 'মোছাঃ মুন্নি বেগম ', 'Housewife', NULL, NULL, '9149609944', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(188, 175, 1, 1, 49, 167, 16, '2024-05-04', 1, 6, 10, 10, '16', NULL, 'Md. Ramjan Hossen', 'মোঃ রমজান হোসেন', '1', NULL, 'Male', 'md.ramjanhossen@gmail.com', '0000-00-00', '20144114771035335', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'মোঃ মিন্টু মোল্যা ', 'Md. Mintu Molla', NULL, NULL, '01992-929798', '3299669436', NULL, 'Mst. Kakole Begum', 'মোছাঃ কাকলী বেগম ', 'Housewife', NULL, NULL, '9574809126', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Bhagabatitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Bhagabatitala, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(189, 176, 1, 1, 49, 168, 17, '2024-05-04', 1, 6, 10, 10, '17', NULL, 'Md. Bhauddin ', 'মোঃ বাহাউদ্দিন ', '1', NULL, 'Male', 'md.bhauddin@gmail.com', '0000-00-00', '20134114001030283', NULL, NULL, '12', 'Bangladeshi', NULL, NULL, 'মোঃ লিটন হোসেন', 'Md. Liton Hossen ', NULL, NULL, '01729-486619', '1949717969', NULL, 'Sumi Khatun', 'সুমি খাতুন', 'Housewife', NULL, NULL, '8660787303', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(190, 177, 1, 1, 49, 169, 18, '2024-12-01', 1, 6, 10, 10, '18', NULL, 'Md. Rafith', 'মোঃ রিফাত', '1', NULL, 'Male', 'md.rafith@gmail.com', '0000-00-00', '20124116144622864', NULL, NULL, '13', 'Bangladeshi', NULL, NULL, 'মোঃ সলেমান ', 'Md. Solaman', NULL, NULL, '01332-382827', '1932151796', NULL, 'Mst. Shainur', 'মোছাঃ শাহিনুর ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Etteha, Po: Kasimnagar, Monirampur, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Etteha, Po: Kasimnagar, Monirampur, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(191, 178, 1, 1, 49, 170, 21, '2025-01-26', 1, 6, 10, 10, '21', NULL, 'Sifat Hossen', 'সিফাত হোসেন', '1', NULL, 'Male', 'sifathossen@gmail.com', '0000-00-00', '20134114771027776', NULL, NULL, '12', 'Bangladeshi', NULL, NULL, 'আছাদুর রহমান ', 'Ashadur Rahaman', NULL, NULL, '01954-788708', '3749710756', NULL, 'Asma Khatun', 'আছমা খাতুন ', 'Housewife', NULL, NULL, '6449690509', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Raimanik, Po: Kachua, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Raimanik, Po: Kachua, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 2300, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(192, 179, 1, 1, 49, 171, 22, '2025-02-12', 1, 6, 10, 10, '22', NULL, 'Md. Tasin Hossen', 'মোঃ তাসিন হোসেন', '1', NULL, 'Male', 'md.tasinhossen@gmail.com', '0000-00-00', '20134114792051166', NULL, NULL, '12', 'Bangladeshi', NULL, NULL, 'মোঃ ইকবাল হোসেন', 'Md. Iqbal Hossain', NULL, NULL, '01729-802429', '8699481217', NULL, 'Mst. Morum Kathun', 'মোছাঃ মরিয়াম  খাতুন ', 'Housewife', NULL, NULL, '5099303439', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ramnagar, Po: Ramnagar, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ramnagar, Po: Ramnagar, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 2300, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(193, 180, 1, 1, 49, 172, 1, '2022-07-22', 1, 7, 10, 10, '01', NULL, 'Md. Raihan Hossen', 'মোঃ রায়হান হোসেন', '1', NULL, 'Male', 'md.raihanhossen@gmail.com', '0000-00-00', '20124110915102739', NULL, NULL, '13', 'Bangladeshi', NULL, NULL, 'মোঃ ইমরান হোসেন', 'Md. Imran Hossen', NULL, NULL, '01922-316961', NULL, NULL, 'Kulsum Begum', 'কুলসুম বেগম', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Srirampur, Po: Charavita, Bagharpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Srirampur, Po: Charavita, Bagharpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(194, 181, 1, 1, 49, 173, 2, '2021-02-10', 1, 7, 10, 10, '02', NULL, 'Md. Yamin Hossain', 'মোঃ ইয়ামিন হোসেন ', '1', NULL, 'Male', 'md.yaminhossain@gmail.com', '0000-00-00', '20084110928023594', NULL, NULL, '17', 'Bangladeshi', NULL, NULL, 'মোঃ কুতুব উদ্দিন ', 'Md. Qutub Uddin', NULL, NULL, '01934-264959', NULL, NULL, 'Rokeya Begum', 'রোকেয়া বেগম ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kalikapur, Po: Chhatiantala, Bagharpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kalikapur, Po: Chhatiantala, Bagharpara, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(195, 182, 1, 1, 49, 174, 3, '2022-05-25', 1, 7, 10, 10, '03', NULL, 'Md. Arafat Hossain', 'মোঃ আরাফাত হোসেন ', '1', NULL, 'Male', 'md.arafathossain@gmail.com', '0000-00-00', '20124114771028902', NULL, NULL, '13', 'Bangladeshi', NULL, NULL, 'মোঃ জাহিদুল ইসলাম ', 'Md. Jahidul Islam', NULL, NULL, '01940-206205', NULL, NULL, 'Sumi Khatun', 'সুমি খাতুন', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(196, 183, 1, 1, 49, 175, 5, '2022-06-26', 1, 7, 10, 10, '05', NULL, 'Md. Shahed Hossain', 'মোঃ শাহেদ হোসেন ', '1', NULL, 'Male', 'md.shahedhossain@gmail.com', '0000-00-00', '20104114771027202', NULL, NULL, '15', 'Bangladeshi', NULL, NULL, 'মোঃ শাহিন হোসেন ', 'Md. Shahin Hossain', NULL, NULL, '01912-604981', NULL, NULL, 'Mst: Hasi Begum', 'মোছাঃ হাসি বেগম ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(197, 184, 1, 1, 49, 176, 6, '2018-12-24', 1, 7, 10, 10, '06', NULL, 'Md. Firoz Hossain', 'মোঃ ফিরোজ হোসেন ', '1', NULL, 'Male', 'md.firozhossain@gmail.com', '0000-00-00', '20074114741051464', NULL, NULL, '18', 'Bangladeshi', NULL, NULL, 'মোঃ রিপন হোসেন ', 'Md. Ripon Hossain', NULL, NULL, '01989-309690', NULL, NULL, 'Mst: Ferdousi Khatun', 'মোসা: ফেরদৌসী খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(198, 185, 1, 1, 49, 177, 7, '2022-06-26', 1, 7, 10, 10, '07', NULL, 'Muntasir Hussain', 'মুন্তাসির হুসাইন ', '1', NULL, 'Male', 'muntasirhussain@gmail.com', '0000-00-00', '20134114741065132', NULL, NULL, '12', 'Bangladeshi', NULL, NULL, 'মাওলানা মোঃ শরীফুল ইসলাম ', 'Maulana Md. Shariful Islam', NULL, NULL, '01933-184236', NULL, NULL, 'Mohsina Yasmin', 'মোহসিনা ইয়াসমিন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(199, 186, 1, 1, 49, 178, 8, '2021-02-05', 1, 7, 10, 10, '08', NULL, 'Azmain Hossain', 'আজমাইন হোসেন ', '1', NULL, 'Male', 'azmainhossain@gmail.com', '0000-00-00', '20094130947102808', NULL, NULL, '16', 'Bangladeshi', NULL, NULL, 'শাহিন পারভেজ ', 'Shaheen Parvez', NULL, NULL, '01882-428351', NULL, NULL, 'Lovely Begum', 'লাভলী বেগম ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Mamudalipur, Po: baharampur, Bagherpara, Jashore', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Mamudalipur, Po: baharampur, Bagherpara, Jashore', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(200, 187, 1, 1, 49, 179, 9, '2022-05-26', 1, 7, 10, 10, '09', NULL, 'Md.Abdur Rahaman', 'মোঃ আব্দুর রহমান', '1', NULL, 'Male', 'md.abdurrahaman@gmail.com', '0000-00-00', '20164121605308900', NULL, NULL, '9', 'Bangladeshi', NULL, NULL, 'মুহাম্মদ রুহুল কুদ্দুস', 'Muhammad Ruhul kuddus', NULL, NULL, '01712-531022', NULL, NULL, 'Rabeya mukta', 'রাবেয়া মুক্তা', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '918 Arabpur, Po: Jashore Sadar 7400, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(201, 188, 1, 1, 49, 180, 10, '2022-09-20', 1, 7, 10, 10, '10', NULL, 'Md. Nihad Hasan', 'মোঃ নিহাদ হাসান ', '1', NULL, 'Male', 'md.nihadhasan@gmail.com', '0000-00-00', '20114114765029215', NULL, NULL, '14', 'Bangladeshi', NULL, NULL, 'মোঃ তুরাপ হোসেন ', 'Md. Turap Hossen', NULL, NULL, '01721-587056', NULL, NULL, 'Mst. Sharmin Akhter', 'মোছাঃ শারমিন আক্তার ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(202, 189, 1, 1, 49, 181, 11, '2022-05-15', 1, 7, 10, 10, '11', NULL, 'Apon Hossain', 'আপন হোসেন ', '1', NULL, 'Male', 'aponhossain@gmail.com', '0000-00-00', '20104114771027767', NULL, NULL, '15', 'Bangladeshi', NULL, NULL, 'মোঃ লালটু হোসেন ', 'Md. Laltu Hossain', NULL, NULL, '01404-628204', NULL, NULL, 'Mst. Shefali Khatun\n', 'মোছাঃ শেফালী খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: kachua, post: kachua, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: kachua, post: kachua, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1000, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(203, 190, 1, 1, 49, 182, 12, '2020-01-28', 1, 7, 10, 10, '12', NULL, 'Mohaiminul Islam Nirab', 'মোহাইমিনুল ইসলাম নীরব ', '1', NULL, 'Male', 'mohaiminulislamnirab@gmail.com', '0000-00-00', '20114114771028719', NULL, NULL, '14', 'Bangladeshi', NULL, NULL, 'মোঃ মিলন হোসেন ', 'Md. Milon Hossain', NULL, NULL, '01724-906451', NULL, NULL, 'Ms. Zohra Khatun', 'মোছাঃ জোহরা খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(204, 191, 1, 1, 49, 183, 13, '2022-05-15', 1, 7, 10, 10, '13', NULL, 'Ramzan Hossain', 'রমজান হোসেন ', '1', NULL, 'Male', 'ramzanhossain@gmail.com', '0000-00-00', '20094114741056736', NULL, NULL, '16', 'Bangladeshi', NULL, NULL, 'লুৎফার রহমান ', 'Lutfar Rahman', NULL, NULL, '01985-958271', NULL, NULL, 'Rashida Begum', 'রাশিদা বেগম ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Fatehpur, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(205, 192, 1, 1, 49, 184, 14, '2023-02-25', 1, 7, 10, 10, '14', NULL, 'Md. Forhad Munshi', 'মোঃ ফরহাদ মুন্সী', '1', NULL, 'Male', 'md.forhadmunshi@gmail.com', '0000-00-00', '20076537611031478', NULL, NULL, '18', 'Bangladeshi', NULL, NULL, 'মুকুল মুন্সী', 'Mukul Munshi', NULL, NULL, '01902-732791', '3743787149', NULL, 'Fatema Begum', 'ফাতেমা বেগম', 'Housewife', NULL, NULL, '6443728636', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Taltala Kamlapur, Po: Auria,Narail Sadar, Narail', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Taltala Kamlapur, Po: Auria,Narail Sadar, Narail', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(206, 193, 1, 1, 49, 185, 15, '2022-09-20', 1, 7, 10, 10, '15', NULL, 'Md. Sabbir Hossen', 'মোঃ সাব্বির হোসেন ', '1', NULL, 'Male', 'md.sabbirhossen@gmail.com', '0000-00-00', '20114114765025157', NULL, NULL, '14', 'Bangladeshi', NULL, NULL, 'আসাদুল ', 'Asadul', NULL, NULL, '01781-424777', NULL, NULL, 'Mst. Jamena Khatun', 'মোছাঃ জামেনা খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(207, 194, 1, 1, 49, 186, 16, '2022-07-10', 1, 7, 10, 10, '16', NULL, 'Md. Abdulla', 'মোঃ আব্দুল্লাহ ', '1', NULL, 'Male', 'md.abdulla@gmail.com', '0000-00-00', '20114114765015092', NULL, NULL, '14', 'Bangladeshi', NULL, NULL, 'মোঃ হালিম', 'Md. Halim', NULL, NULL, '01718-765111', NULL, NULL, 'Mst. Doly Khatun', 'মোছাঃ ডলি খাতুন ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36');
INSERT INTO `stm_students` (`id`, `_user_table_id`, `organization_id`, `_branch_id`, `_account_group_id`, `_ledger_id`, `_roll_no`, `_admission_date`, `_admission_session_id`, `_education_type`, `_admission_class_id`, `_current_class_id`, `_student_id`, `_proximity_card_no`, `_name_in_english`, `_name_in_bangla`, `_religion`, `_student_image`, `_gender`, `_email`, `_date_of_birth`, `_barth_id`, `_bloodgroup`, `_s_identification_mark`, `_age`, `_nationality`, `_height`, `_weight`, `_father_name_bangla`, `_father_name_english`, `_occupation`, `_annual_income`, `_f_mobile_no`, `_f_nid_no`, `_f_email`, `_mother_name_english`, `_mother_name_of_bangla`, `_mother_occupation`, `_mother_mobile_no`, `_mother_anual_income`, `_mother_nid_no`, `_mother_email`, `_local_guardian_name`, `_local_guardian_occupation`, `_local_guardian_address`, `_local_guardian_mobile`, `_local_guardian_nid`, `_local_guardian_nid_image`, `_present_address`, `_per_country_id`, `_per_division_id`, `_per_district_id`, `_per_thana_id`, `_per_union_id`, `_cur_division_id`, `_cur_country_id`, `_cur_district_id`, `_cur_thana_id`, `_cur_union_id`, `_per_post_office`, `_cur_post_office`, `_parmanent_address`, `_previous_institute_name`, `_pre_class`, `_pre_result`, `_pre_roll_no`, `_father_nid_image`, `_mother_nid_image`, `_birth_certificate`, `_transfer_certificate`, `_testimonial`, `_academic_certificate`, `_marksheet`, `_student_photo`, `_adminssion_fee_amount`, `_monthly_fee`, `_resedential_type`, `_parents_signature`, `_main_subjects`, `_optional_subjects`, `_detail`, `_user_id`, `_user_name`, `_status`, `_lock`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(208, 195, 1, 1, 49, 187, 17, '2023-12-18', 1, 7, 10, 10, '17', NULL, 'Md. Siam Hossain', 'মোঃ সিয়াম হোসেন ', '1', NULL, 'Male', 'md.siamhossain@gmail.com', '0000-00-00', '20114114741051989', NULL, NULL, '12', 'Bangladeshi', NULL, NULL, 'মোঃ আবু বক্কর ', 'Md. Abu Bokkor', NULL, NULL, '01745-775769', NULL, NULL, 'Parul Begum', 'পারুল বেগম ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Chandpara, Po: Hamidpur, sadar Jashore, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Chandpara, Po: Hamidpur, sadar Jashore, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(209, 196, 1, 1, 49, 188, 18, '2022-05-14', 1, 7, 10, 10, '18', NULL, 'Khandaker Al-Karimu Islam ', 'খন্দকার আল-কারিমু ইসলাম ', '1', NULL, 'Male', 'khandakeral-karimuislam @gmail.com', '0000-00-00', '20114114710357072', NULL, NULL, '14', 'Bangladeshi', NULL, NULL, 'খন্দকার মোঃ জিয়াউর রহমান ', 'Khandaker Md. Ziaur Rahman ', NULL, NULL, '01737-250411', NULL, NULL, 'Mst. Minuja Begum', 'মোছাঃ মিনুজা বেগম ', 'Housewife', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Vekutia, Po: Vekutia, Sadar Jashore,Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Vekutia, Po: Vekutia, Sadar Jashore,Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1200, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(210, 197, 1, 1, 49, 189, 20, '2020-01-28', 1, 7, 10, 10, '20', NULL, 'Md. Lipu Sultan Momin', 'মোঃ লিপু সুলতান মোমিন ', '1', NULL, 'Male', 'md.lipusultanmomin@gmail.com', '0000-00-00', '20104114771017615', NULL, NULL, '15', 'Bangladeshi', NULL, NULL, 'মোঃ রিপন মোল্লা ', 'Md. Ripon Molla', NULL, NULL, '01724-906451', NULL, NULL, 'Mst. Rabeya Begum', 'মোছাঃ রাবেয়া বেগম ', 'Housewife', '01786-636417', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Ghop, Po: Fatehpur, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(211, 198, 1, 1, 49, 190, 21, '2024-12-04', 1, 7, 10, 10, '21', NULL, 'Jisan', 'জিসান ', '1', NULL, 'Male', 'jisan@gmail.com', '0000-00-00', '20154413381028126', NULL, NULL, '10', 'Bangladeshi', NULL, NULL, 'মোঃ শামিরুল ', 'Md. Shamirul', NULL, NULL, '01622-432237', NULL, NULL, 'Sabina Yasmin', 'সাবিনা ইয়াসমিন ', 'Housewife', NULL, NULL, '5539775790', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Bogergachi, Po: Bogergachi Bazar, Kaligonj, Jhenaidah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Bogergachi, Po: Bogergachi Bazar, Kaligonj, Jhenaidah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 2300, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(212, 199, 1, 1, 49, 191, 22, '2025-04-10', 1, 7, 10, 10, '22', NULL, 'Md. Baijit', 'মোঃ বাইজীত ', '1', NULL, 'Male', 'md.baijit@gmail.com', '0000-00-00', '20124114765024180', NULL, NULL, '13', 'Bangladeshi', NULL, NULL, 'আব্দুর রশিদ ', 'Abdur Rashid', NULL, NULL, '01746-373641', '2398886073', NULL, 'Nargis Begum', 'নার্গিস বেগম ', 'Housewife', NULL, NULL, '5548766483', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Vill: Kojarhat, Po: Kojarhat, Jashore Sadar, Jashore.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 500, 2500, '1', NULL, NULL, NULL, NULL, 46, 'admin', 1, 0, '49', '49', '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(213, 164, 1, 1, 49, 509, 4, '2019-11-20', 1, 7, 10, 0, '1', '1', 'MD. Waliulla', 'মোঃ ওলিউল্যা', '', 'images/2.jpg', 'Male', '', '2009-01-31', '20094110915108143', '', '', '', '', '', '', 'মোঃ ইলিয়াছ  হোসেন', 'Md. Elias Hossen', '', '', '01720-356536', '', '', 'Mst. Rekjan Khatun', 'মোছাঃ রেকজান খাতুন', '', '', '', '', '', '', '', '', '', '', '', '0', 2, 0, 0, '0', 0, 0, 2, 0, '0', 0, '0', '0', '', '', '', '', '', NULL, NULL, 'images/1.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, '2', NULL, '6', '', '', 46, 'Admin', 0, 0, NULL, NULL, '2025-05-22 16:07:05', '2025-05-22 16:28:12'),
(214, 164, 1, 1, 49, 510, 19, '2022-03-01', 1, 7, 10, 0, '1', '1', 'Omar Gazi', 'ওমর গাজি', 'Islam', 'images/17479096078952712293206871484855.jpg', 'Male', '', '2009-01-05', '20094114741052600', '', '', '', '', '', '', 'Razu Gazi', 'রাজু গাজি', '', '', '01966994761', '', '', 'Sokina Begum', 'সকিনা বেগম', '', '', '', '', '', '', '', '', '', '', '', '0', 2, 0, 0, '0', 0, 0, 2, 0, '0', 0, '7400', '0', '', '', '', '', '', NULL, NULL, 'images/17479100065687559671171790659427.jpg', NULL, NULL, NULL, NULL, NULL, 1, 1, '2', NULL, '6', '4', '', 46, 'Admin', 0, 0, NULL, NULL, '2025-05-22 16:34:00', '2025-05-25 11:13:04');

-- --------------------------------------------------------

--
-- Table structure for table `stm_subjects`
--

CREATE TABLE `stm_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_created_by` int(11) NOT NULL DEFAULT 0,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stm_subjects`
--

INSERT INTO `stm_subjects` (`id`, `_name`, `_code`, `_user_id`, `_status`, `_user_name`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(4, 'Bangla', 'Bangla', 46, 1, 'Admin', 0, 0, '2025-05-12 18:43:49', '2025-05-12 18:43:49'),
(5, 'English', 'English', 46, 1, 'Admin', 0, 0, '2025-05-12 18:43:57', '2025-05-12 18:43:57'),
(6, 'Arabic', 'Arabic', 46, 1, 'Admin', 0, 0, '2025-05-12 18:44:09', '2025-05-12 18:44:09');

-- --------------------------------------------------------

--
-- Table structure for table `stock_ins`
--

CREATE TABLE `stock_ins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` float NOT NULL DEFAULT 0,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_expected_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_warranty` varchar(255) NOT NULL DEFAULT '0',
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_receive_qty` double(15,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_outs`
--

CREATE TABLE `stock_outs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_unit_conversion` float NOT NULL DEFAULT 0,
  `_transection_unit` int(11) NOT NULL DEFAULT 0,
  `_base_unit` int(11) NOT NULL DEFAULT 0,
  `_base_rate` float NOT NULL DEFAULT 0,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL,
  `_expected_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` varchar(255) NOT NULL DEFAULT '0',
  `_barcode` varchar(255) DEFAULT NULL,
  `_purchase_invoice_no` int(11) NOT NULL DEFAULT 0,
  `_purchase_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_houses`
--

CREATE TABLE `store_houses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) NOT NULL,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_address` longtext DEFAULT NULL,
  `_authorised_person` varchar(255) DEFAULT NULL,
  `_contact_info` text DEFAULT NULL,
  `_status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `order` double(15,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_houses`
--

INSERT INTO `store_houses` (`id`, `_name`, `_code`, `_branch_id`, `_address`, `_authorised_person`, `_contact_info`, `_status`, `created_at`, `updated_at`, `status`, `is_delete`, `order`) VALUES
(1, 'Head Office', 'HO', 1, NULL, NULL, NULL, 1, NULL, NULL, 0, 0, 0.0000);

-- --------------------------------------------------------

--
-- Table structure for table `store_house_selves`
--

CREATE TABLE `store_house_selves` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) NOT NULL,
  `_branch_id` int(11) NOT NULL,
  `_store_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_class_subjects`
--

CREATE TABLE `student_class_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_student_id` int(11) NOT NULL DEFAULT 0,
  `_class_id` int(11) NOT NULL DEFAULT 0,
  `_education_type` int(11) NOT NULL DEFAULT 0,
  `_subjects` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_created_by` int(11) NOT NULL DEFAULT 0,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_voucher_id` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(255) DEFAULT NULL,
  `_defalut_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_note` varchar(255) DEFAULT NULL,
  `_document` varchar(255) DEFAULT NULL,
  `_voucher_type` varchar(255) DEFAULT NULL,
  `_transection_type` varchar(255) DEFAULT NULL,
  `_transection_ref` varchar(255) DEFAULT NULL,
  `_form_name` varchar(255) DEFAULT NULL,
  `_ref_table` varchar(255) DEFAULT NULL,
  `_amount` double NOT NULL DEFAULT 0,
  `_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_ledger_balance` double NOT NULL DEFAULT 0,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payment_details`
--

CREATE TABLE `supplier_payment_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` int(11) NOT NULL DEFAULT 0,
  `_voucher_code` varchar(255) DEFAULT NULL,
  `_ref_id` int(11) NOT NULL DEFAULT 0,
  `_table` varchar(255) DEFAULT NULL,
  `_invoice_id` varchar(255) DEFAULT NULL,
  `_invoice_number` varchar(255) DEFAULT NULL,
  `_total` double NOT NULL DEFAULT 0,
  `_receive_amount` double NOT NULL DEFAULT 0,
  `_due_amount` double NOT NULL DEFAULT 0,
  `_collection_amount` double NOT NULL DEFAULT 0,
  `_due_balance` double NOT NULL DEFAULT 0,
  `_type` varchar(255) DEFAULT NULL,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_collection_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_short_narr` text DEFAULT NULL,
  `_is_adjust` tinyint(4) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_close` tinyint(4) NOT NULL DEFAULT 0,
  `_is_effect` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_customform`
--

CREATE TABLE `sys_customform` (
  `_id` int(11) NOT NULL DEFAULT 0,
  `_serial` int(11) NOT NULL DEFAULT 0,
  `_table` varchar(100) NOT NULL,
  `_name` varchar(100) NOT NULL,
  `_type` enum('0','1','2','3') NOT NULL DEFAULT '1',
  `_groupmenu` varchar(60) DEFAULT NULL,
  `_underfrom` varchar(100) DEFAULT NULL,
  `_option` longtext DEFAULT NULL,
  `_event` longtext DEFAULT NULL,
  `_tabletype` int(11) NOT NULL DEFAULT 0,
  `created_at` date DEFAULT NULL,
  `_updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sys_customformfields`
--

CREATE TABLE `sys_customformfields` (
  `_id` int(11) NOT NULL DEFAULT 0,
  `_tableid` int(11) NOT NULL DEFAULT 0,
  `_field` varchar(100) NOT NULL,
  `_name` varchar(50) NOT NULL,
  `_datatype` int(11) NOT NULL DEFAULT 0,
  `_size` int(11) NOT NULL DEFAULT 0,
  `_childtable` longtext DEFAULT NULL,
  `_unique` enum('1','0') NOT NULL,
  `_list` enum('1','0') NOT NULL DEFAULT '1',
  `_group` enum('1','0') NOT NULL DEFAULT '0',
  `_required` enum('1','0') NOT NULL DEFAULT '1',
  `_readonly` enum('1','0') NOT NULL DEFAULT '0',
  `_extsearch` enum('1','0') NOT NULL DEFAULT '0',
  `_default` varchar(50) NOT NULL,
  `_tabs` int(11) NOT NULL DEFAULT 0,
  `_add` enum('1','0') NOT NULL DEFAULT '1',
  `_edit` enum('1','0') NOT NULL DEFAULT '1',
  `_serial` int(11) NOT NULL DEFAULT 0,
  `_created_at` date DEFAULT NULL,
  `_updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_infos`
--

CREATE TABLE `table_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_branch_id` int(11) NOT NULL DEFAULT 1,
  `_name` varchar(255) NOT NULL,
  `_number_of_chair` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ta_da_setups`
--

CREATE TABLE `ta_da_setups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_fescal_year` varchar(255) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_sloat_min` double NOT NULL DEFAULT 0,
  `_sloat_max` double NOT NULL DEFAULT 0,
  `_ta_rate` double NOT NULL DEFAULT 0,
  `_fixed_amount` double NOT NULL DEFAULT 0,
  `_type` varchar(50) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cus_categories`
--

CREATE TABLE `tbl_cus_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `is_security` tinyint(4) NOT NULL DEFAULT 0,
  `_code` varchar(60) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tranport_types`
--

CREATE TABLE `tranport_types` (
  `id` int(11) NOT NULL DEFAULT 0,
  `_name` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transection_terms`
--

CREATE TABLE `transection_terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) DEFAULT NULL,
  `_days` int(11) NOT NULL DEFAULT 0,
  `_detail` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_font_color` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transection_terms`
--

INSERT INTO `transection_terms` (`id`, `_name`, `_days`, `_detail`, `_status`, `created_at`, `updated_at`, `_font_color`) VALUES
(1, 'Cash', 0, 'N/A', 1, '2023-01-09 04:24:22', '2023-01-15 07:59:35', NULL),
(2, '30 Days Credit', 30, 'N/A', 1, '2023-01-09 04:25:21', '2023-01-15 08:01:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(100) NOT NULL,
  `_code` varchar(100) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `_name`, `_code`, `_status`, `_created_by`, `_updated_by`, `created_at`, `updated_at`) VALUES
(1, 'MT', 'MT', 1, NULL, NULL, '2023-11-12 04:56:13', '2023-11-15 08:23:09'),
(2, 'PCS', 'PCS', 1, NULL, NULL, '2023-12-20 09:54:54', '2023-12-20 09:54:54'),
(3, 'KG', 'KG', 1, NULL, NULL, '2023-12-20 09:55:10', '2023-12-20 09:55:10'),
(4, 'BAG', 'BAG', 1, NULL, NULL, '2023-12-20 09:55:21', '2023-12-20 09:55:21'),
(5, 'Inch', 'Inch', 1, NULL, NULL, '2023-12-20 09:55:38', '2023-12-20 09:55:38'),
(6, 'CFT', 'CFT', 1, NULL, NULL, '2023-12-20 09:56:22', '2023-12-20 09:56:22'),
(7, 'Feet', 'Feet', 1, NULL, NULL, '2024-01-11 04:04:45', '2024-01-11 04:04:45'),
(8, 'MTR', 'mtr', 1, NULL, NULL, '2024-01-11 04:37:55', '2024-01-11 04:37:55'),
(9, 'Pair', '', 1, NULL, NULL, '2024-01-29 11:55:48', '2024-01-29 11:55:48'),
(10, 'Galon', '', 1, NULL, NULL, '2024-03-01 09:13:13', '2024-03-01 09:13:13'),
(11, 'Packet', '', 1, NULL, NULL, '2024-03-01 09:15:04', '2024-03-01 09:15:04'),
(12, 'Red Oxide', 'Galon', 1, NULL, NULL, '2024-03-01 10:07:21', '2024-03-01 10:07:56'),
(13, 'Lum Sum', '', 1, NULL, NULL, '2024-04-16 05:21:05', '2024-04-16 05:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `unit_conversions`
--

CREATE TABLE `unit_conversions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` int(11) NOT NULL,
  `_base_unit_id` int(11) NOT NULL,
  `_conversion_qty` double NOT NULL,
  `_conversion_unit` int(11) NOT NULL,
  `_status` int(11) NOT NULL,
  `_conversion_unit_name` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upazilas`
--

CREATE TABLE `upazilas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `division_id` int(11) NOT NULL DEFAULT 0,
  `district_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `bn_name` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'visitor' COMMENT 'admin,user,visitor,applicant',
  `organization_ids` varchar(200) DEFAULT NULL,
  `branch_ids` varchar(255) DEFAULT '0',
  `cost_center_ids` varchar(255) DEFAULT '0',
  `store_ids` varchar(255) DEFAULT NULL,
  `ref_id` int(11) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `_ac_type` tinyint(4) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_name`, `email`, `image`, `user_type`, `organization_ids`, `branch_ids`, `cost_center_ids`, `store_ids`, `ref_id`, `email_verified_at`, `password`, `status`, `_is_delete`, `_ac_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Tarafder Md Ruhul Saif', 'SPL-000004', 'saif@saifpowertec.com', NULL, 'visitor', '1', '1', '24,14,29,30,3,25,26,33,9,13,20,10,7,15,32,34,22,37,36,6,28,27,23,11,2,4,31,21,16,12,19,18,1,8,5,17', '1', 0, NULL, '$2y$10$O8.hW/aX71vhYPDLVD/R1.rj2M7pMZcTrDCW/yb2eXI5nuIWPruym', 1, 0, 0, NULL, '2021-05-29 11:35:46', '2024-06-25 09:51:08'),
(46, 'Admin', 'admin', 'admin@saifpowertec.com', 'images/1023202313411265362398c0643.png', 'admin', '1', '1', '24,14,29,30,3,25,26,33,9,13,20,10,7,15,32,34,22,37,36,6,28,27,23,11,2,4,31,21,16,12,19,18,1,8,5,17', '1', 0, NULL, '$2y$10$EiW6GszFGnsFmuPGEWna0.kxsPdDgugr0ngiQI.ialfsSy786z4Xq', 1, 0, 0, NULL, '2022-03-04 14:08:25', '2024-06-25 09:51:05'),
(49, 'Shihab', 'accounts', 'accounts@tmm.com', NULL, 'admin', '1', '1', '1', '1', 0, NULL, '$2y$10$6SafzvqLlAWDT1EsuQZUV.0F8Rc.OTsihb4V0VLtbhRgEyv3R2msu', 1, 0, 0, NULL, '2022-06-08 14:05:17', '2025-04-23 12:21:51'),
(72, 'Mst. Samia Khatun', '1', 'mst.samiakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 54, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:15:10', '2025-05-12 17:15:10'),
(73, 'Mst. Samia Khatun', '00001', 'mst.samiakhatun@gmail.com.1@gmail.com', NULL, 'user', '1', '1', '1', NULL, 55, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(74, 'Mst. Suraiya Khatun', '00002', 'mst.suraiyakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 56, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(75, 'Md. Siyam Molla', '00003', 'md.siyammolla@gmail.com', NULL, 'user', '1', '1', '1', NULL, 57, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(76, 'Md. Khalid Bin Walid Yeamin', '00004', 'md.khalidbinwalidyeamin@gmail.com', NULL, 'user', '1', '1', '1', NULL, 58, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(77, 'Rafin Hasan', '00005', 'rafinhasan@gmail.com', NULL, 'user', '1', '1', '1', NULL, 59, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(78, 'Md. Sohaib Ansari', '00006', 'md.sohaibansari@gmail.com', NULL, 'user', '1', '1', '1', NULL, 60, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(79, 'Tasin Hasan Ahad', '00007', 'tasinhasanahad@gmail.com', NULL, 'user', '1', '1', '1', NULL, 61, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(80, 'Mst. Jannati Khatun', '00008', 'mst.jannatikhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 62, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(81, 'Raisa Akhter Roza', '00009', 'raisaakhterroza@gmail.com', NULL, 'user', '1', '1', '1', NULL, 63, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:05', '2025-05-12 17:17:05'),
(82, 'Mst. Saima Khatun', '00010', 'mst.saimakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 64, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(83, 'Mst. Rusa Khatun', '00011', 'mst.rusakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 65, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(84, 'Elma Khatun', '00012', 'elmakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 66, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(85, 'Hriday Hossain', '00013', 'hridayhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 67, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(86, 'Litun Jira', '00014', 'litunjira@gmail.com', NULL, 'user', '1', '1', '1', NULL, 68, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(87, 'Mst. Humayra Khatun Johani', '00015', 'mst.humayrakhatunjohani@gmail.com', NULL, 'user', '1', '1', '1', NULL, 69, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(88, 'Afrin', '00016', 'afrin@gmail.com', NULL, 'user', '1', '1', '1', NULL, 70, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(89, 'Amir Hamza', '00017', 'amirhamza@gmail.com', NULL, 'user', '1', '1', '1', NULL, 71, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(90, 'Al-Alim', '00018', 'al-alim@gmail.com', NULL, 'user', '1', '1', '1', NULL, 72, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(91, 'Mohammad Ullah', '00019', 'mohammadullah@gmail.com', NULL, 'user', '1', '1', '1', NULL, 73, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(92, 'Sifat Bin Sofik', '00020', 'sifatbinsofik@gmail.com', NULL, 'user', '1', '1', '1', NULL, 74, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(93, 'Aysha Khatun', '00021', 'ayshakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 75, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(94, 'Safia Akter Sohi', '00022', 'safiaaktersohi@gmail.com', NULL, 'user', '1', '1', '1', NULL, 76, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(95, 'Fatama Akter Anisha', '00023', 'fatamaakteranisha@gmail.com', NULL, 'user', '1', '1', '1', NULL, 77, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(96, 'Zannati Khatun', '00024', 'zannatikhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 78, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(97, 'Tazmir hossen', '00025', 'tazmirhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 79, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(98, 'Md. Shahed Hossan', '00026', 'md.shahedhossan@gmail.com', NULL, 'user', '1', '1', '1', NULL, 80, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(99, 'Mst. Jannatul Khatun', '00027', 'mst.jannatulkhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 81, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(100, 'Ayeat Islam', '00028', 'ayeatislam@gmail.com', NULL, 'user', '1', '1', '1', NULL, 82, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(101, 'Mohsina Mariam', '00029', 'mohsinamariam@gmail.com', NULL, 'user', '1', '1', '1', NULL, 83, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(102, 'Mst. Maliha Jannat', '00030', 'mst.malihajannat@gmail.com', NULL, 'user', '1', '1', '1', NULL, 84, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(103, 'Rafid Hossen', '00031', 'rafidhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 85, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(104, 'Md. Sajjad Hossain', '00032', 'md.sajjadhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 86, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(105, 'Md. Sazim Hossen', '00033', 'md.sazimhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 87, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(106, 'Md. Siyam Hossen', '00034', 'md.siyamhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 88, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(107, 'Mst. Khadija Khatun', '00035', 'mst.khadijakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 89, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(108, 'Ashmatulya Hussain', '00036', 'ashmatulyahussain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 90, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(109, 'Abu Hussain Tamim', '00037', 'abuhussaintamim@gmail.com', NULL, 'user', '1', '1', '1', NULL, 91, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(110, 'Md. Jubayer Hossen', '00038', 'md.jubayerhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 92, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(111, 'Tasnim Khatun', '00039', 'tasnimkhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 93, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(112, 'Mst. Homaira Khatun', '00040', 'mst.homairakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 94, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(113, 'Mst. Jacia Khatun ', '00041', 'mst.jaciakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 95, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(114, 'Roshan azam', '00042', 'roshanazam@gmail.com', NULL, 'user', '1', '1', '1', NULL, 96, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(115, 'Ajmain Hasan Rijvi', '00043', 'ajmainhasanrijvi@gmail.com', NULL, 'user', '1', '1', '1', NULL, 97, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(116, 'Md. Mustakim Hossain', '00044', 'md.mustakimhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 98, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(117, 'Mst. Sumaiya Khatun', '00045', 'mst.sumaiyakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 99, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(118, 'Arisha Akhtar', '00046', 'arishaakhtar@gmail.com', NULL, 'user', '1', '1', '1', NULL, 100, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(119, 'Md. Tamim Hasan', '00047', 'md.tamimhasan@gmail.com', NULL, 'user', '1', '1', '1', NULL, 101, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(120, 'Md. Amanullah', '00048', 'md.amanullah@gmail.com', NULL, 'user', '1', '1', '1', NULL, 102, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(121, 'Riyadh', '00049', 'riyadh@gmail.com', NULL, 'user', '1', '1', '1', NULL, 103, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(122, 'Tachin Ahmed', '00050', 'tachinahmed@gmail.com', NULL, 'user', '1', '1', '1', NULL, 104, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(123, 'Abrar Fahim', '00051', 'abrarfahim@gmail.com', NULL, 'user', '1', '1', '1', NULL, 105, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(124, 'Md. Billal Hosen', '00052', 'md.billalhosen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 106, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:06', '2025-05-12 17:17:06'),
(125, 'Mst. Tabassum Khatun', '00053', 'mst.tabassumkhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 107, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(126, 'Maimun Jubayer', '00054', 'maimunjubayer@gmail.com', NULL, 'user', '1', '1', '1', NULL, 108, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(127, 'Lamia Min Samia', '00055', 'lamiaminsamia@gmail.com', NULL, 'user', '1', '1', '1', NULL, 109, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(128, 'Mst. Samiya Akter', '00056', 'mst.samiyaakter@gmail.com', NULL, 'user', '1', '1', '1', NULL, 110, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(129, 'Md. Imtiaz Hossain Imu', '00057', 'md.imtiazhossainimu@gmail.com', NULL, 'user', '1', '1', '1', NULL, 111, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(130, 'Md. Ahnaf Abid', '00058', 'md.ahnafabid@gmail.com', NULL, 'user', '1', '1', '1', NULL, 112, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(131, 'Amatulla Tasnim Maroa', '00059', 'amatullatasnimmaroa@gmail.com', NULL, 'user', '1', '1', '1', NULL, 113, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(132, 'Md. Abu Jorr', '00060', 'md.abujorr@gmail.com', NULL, 'user', '1', '1', '1', NULL, 114, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(133, 'Taskin Hussain', '00061', 'taskinhussain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 115, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(134, 'Md. Jayed Sabit', '00062', 'md.jayedsabit@gmail.com', NULL, 'user', '1', '1', '1', NULL, 116, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(135, 'Tasmin Nahar Sinthia', '00063', 'tasminnaharsinthia@gmail.com', NULL, 'user', '1', '1', '1', NULL, 117, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(136, 'Mst. Lamia Akter', '00064', 'mst.lamiaakter@gmail.com', NULL, 'user', '1', '1', '1', NULL, 118, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(137, 'Mst. Aysha Seddika', '00065', 'mst.ayshaseddika@gmail.com', NULL, 'user', '1', '1', '1', NULL, 119, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(138, 'Md. Mustakim Hossen', '00066', 'md.mustakimhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 120, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(139, 'Md. Muzahid Hossen', '00067', 'md.muzahidhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 121, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(140, 'Md. Abdur Rahman', '00068', 'md.abdurrahman@gmail.com', NULL, 'user', '1', '1', '1', NULL, 122, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(141, 'Mst. Mariam Khatun', '00069', 'mst.mariamkhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 123, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(142, 'Nasim Hossen', '00070', 'nasimhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 124, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(143, 'Md. Hussain ', '00071', 'md.hussain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 125, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(144, 'Safia Khatun', '00072', 'safiakhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 126, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(145, 'Mst. Eshita ', '00073', 'mst.eshita@gmail.com', NULL, 'user', '1', '1', '1', NULL, 127, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(146, 'Mst. Moriam Khatun', '00074', 'mst.moriamkhatun@gmail.com', NULL, 'user', '1', '1', '1', NULL, 128, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(147, 'Jannatul Ferdous Toha', '00075', 'jannatulferdoustoha@gmail.com', NULL, 'user', '1', '1', '1', NULL, 129, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(148, 'Mst. Mim Akter', '00076', 'mst.mimakter@gmail.com', NULL, 'user', '1', '1', '1', NULL, 130, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(149, 'Mumtahina Mahmuda', '00077', 'mumtahinamahmuda@gmail.com', NULL, 'user', '1', '1', '1', NULL, 131, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(150, 'Md. Samiul Islam', '00078', 'md.samiulislam@gmail.com', NULL, 'user', '1', '1', '1', NULL, 132, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(151, 'Md. Abu Talha Rabby', '00079', 'md.abutalharabby@gmail.com', NULL, 'user', '1', '1', '1', NULL, 133, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(152, 'Md. Rafsan Hossain', '00080', 'md.rafsanhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 134, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(153, 'Md. Jihad Hasan Chiku', '00081', 'md.jihadhasanchiku@gmail.com', NULL, 'user', '1', '1', '1', NULL, 135, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:07', '2025-05-12 17:17:07'),
(154, 'Md. Jidni Hasan', '00082', 'md.jidnihasan@gmail.com', NULL, 'user', '1', '1', '1', NULL, 136, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(155, 'Md. Sihab Uddin', '00083', 'md.sihabuddin@gmail.com', NULL, 'user', '1', '1', '1', NULL, 137, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(156, 'Muttasin Islam Noman\n', '00084', 'muttasinislamnoman\n@gmail.com', NULL, 'user', '1', '1', '1', NULL, 138, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(157, 'Md. Alif Hasan Sawm', '00085', 'md.alifhasansawm@gmail.com', NULL, 'user', '1', '1', '1', NULL, 139, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(158, 'Md. Hossain', '00086', 'md.hossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 140, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(159, 'Namia Akter Najifa', '00087', 'namiaakternajifa@gmail.com', NULL, 'user', '1', '1', '1', NULL, 141, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(160, '', '00088', '@gmail.com', NULL, 'user', '1', '1', '1', NULL, 142, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(161, '', '00089', '@gmail.com.1@gmail.com', NULL, 'user', '1', '1', '1', NULL, 143, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(162, '', '00090', '@gmail.com.2@gmail.com', NULL, 'user', '1', '1', '1', NULL, 144, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(163, '', '00091', '@gmail.com.3@gmail.com', NULL, 'user', '1', '1', '1', NULL, 145, NULL, '', 1, 0, 0, NULL, '2025-05-12 17:17:08', '2025-05-12 17:17:08'),
(164, 'Md.Jubayet Hossen', '00092', '', NULL, 'user', '1', '1', '1', NULL, 156, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:01:16', '2025-05-19 12:01:16'),
(165, 'Tanveen Hassan Adar', '00093', 'tanveenhassanadar@gmail.com', NULL, 'user', '1', '1', '1', NULL, 157, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(166, 'Md. Easin Arafat', '00094', 'md.easinarafat@gmail.com', NULL, 'user', '1', '1', '1', NULL, 158, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(167, 'Huzaifa Jubayer', '00095', 'huzaifajubayer@gmail.com', NULL, 'user', '1', '1', '1', NULL, 159, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(168, 'Sabid Hasan', '00096', 'sabidhasan@gmail.com', NULL, 'user', '1', '1', '1', NULL, 160, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(169, 'Fahim Foysal', '00097', 'fahimfoysal@gmail.com', NULL, 'user', '1', '1', '1', NULL, 161, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(170, 'Md. Aminur Rahaman', '00098', 'md.aminurrahaman@gmail.com', NULL, 'user', '1', '1', '1', NULL, 162, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(171, 'Md.Ismail hossain.', '00099', 'md.ismailhossain.@gmail.com', NULL, 'user', '1', '1', '1', NULL, 163, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:35', '2025-05-19 12:13:35'),
(172, 'Mohammad Ullah', '00100', 'mohammadullah@gmail.com.1@gmail.com', NULL, 'user', '1', '1', '1', NULL, 164, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(173, 'Zihad Islam', '00101', 'zihadislam@gmail.com', NULL, 'user', '1', '1', '1', NULL, 165, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(174, 'Md. Jihadul Islam Jihad', '00102', 'md.jihadulislamjihad@gmail.com', NULL, 'user', '1', '1', '1', NULL, 166, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(175, 'Md. Ramjan Hossen', '00103', 'md.ramjanhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 167, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(176, 'Md. Bhauddin ', '00104', 'md.bhauddin@gmail.com', NULL, 'user', '1', '1', '1', NULL, 168, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(177, 'Md. Rafith', '00105', 'md.rafith@gmail.com', NULL, 'user', '1', '1', '1', NULL, 169, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(178, 'Sifat Hossen', '00106', 'sifathossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 170, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(179, 'Md. Tasin Hossen', '00107', 'md.tasinhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 171, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(180, 'Md. Raihan Hossen', '00108', 'md.raihanhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 172, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(181, 'Md. Yamin Hossain', '00109', 'md.yaminhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 173, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(182, 'Md. Arafat Hossain', '00110', 'md.arafathossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 174, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(183, 'Md. Shahed Hossain', '00111', 'md.shahedhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 175, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(184, 'Md. Firoz Hossain', '00112', 'md.firozhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 176, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(185, 'Muntasir Hussain', '00113', 'muntasirhussain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 177, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(186, 'Azmain Hossain', '00114', 'azmainhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 178, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(187, 'Md.Abdur Rahaman', '00115', 'md.abdurrahaman@gmail.com', NULL, 'user', '1', '1', '1', NULL, 179, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(188, 'Md. Nihad Hasan', '00116', 'md.nihadhasan@gmail.com', NULL, 'user', '1', '1', '1', NULL, 180, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(189, 'Apon Hossain', '00117', 'aponhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 181, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(190, 'Mohaiminul Islam Nirab', '00118', 'mohaiminulislamnirab@gmail.com', NULL, 'user', '1', '1', '1', NULL, 182, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(191, 'Ramzan Hossain', '00119', 'ramzanhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 183, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(192, 'Md. Forhad Munshi', '00120', 'md.forhadmunshi@gmail.com', NULL, 'user', '1', '1', '1', NULL, 184, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(193, 'Md. Sabbir Hossen', '00121', 'md.sabbirhossen@gmail.com', NULL, 'user', '1', '1', '1', NULL, 185, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(194, 'Md. Abdulla', '00122', 'md.abdulla@gmail.com', NULL, 'user', '1', '1', '1', NULL, 186, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(195, 'Md. Siam Hossain', '00123', 'md.siamhossain@gmail.com', NULL, 'user', '1', '1', '1', NULL, 187, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(196, 'Khandaker Al-Karimu Islam ', '00124', 'khandakeral-karimuislam @gmail.com', NULL, 'user', '1', '1', '1', NULL, 188, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(197, 'Md. Lipu Sultan Momin', '00125', 'md.lipusultanmomin@gmail.com', NULL, 'user', '1', '1', '1', NULL, 189, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(198, 'Jisan', '00126', 'jisan@gmail.com', NULL, 'user', '1', '1', '1', NULL, 190, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(199, 'Md. Baijit', '00127', 'md.baijit@gmail.com', NULL, 'user', '1', '1', '1', NULL, 191, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(200, '', '00128', '@gmail.com.4@gmail.com', NULL, 'user', '1', '1', '1', NULL, 192, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(201, '', '00129', '@gmail.com.5@gmail.com', NULL, 'user', '1', '1', '1', NULL, 193, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(202, '', '00130', '@gmail.com.6@gmail.com', NULL, 'user', '1', '1', '1', NULL, 194, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(203, '', '00131', '@gmail.com.7@gmail.com', NULL, 'user', '1', '1', '1', NULL, 195, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(204, '', '00132', '@gmail.com.8@gmail.com', NULL, 'user', '1', '1', '1', NULL, 196, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(205, '', '00133', '@gmail.com.9@gmail.com', NULL, 'user', '1', '1', '1', NULL, 197, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(206, '', '00134', '@gmail.com.10@gmail.com', NULL, 'user', '1', '1', '1', NULL, 198, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(207, '', '00135', '@gmail.com.11@gmail.com', NULL, 'user', '1', '1', '1', NULL, 199, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:36', '2025-05-19 12:13:36'),
(208, '', '00136', '@gmail.com.12@gmail.com', NULL, 'user', '1', '1', '1', NULL, 200, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(209, '', '00137', '@gmail.com.13@gmail.com', NULL, 'user', '1', '1', '1', NULL, 201, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(210, '', '00138', '@gmail.com.14@gmail.com', NULL, 'user', '1', '1', '1', NULL, 202, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(211, '', '00139', '@gmail.com.15@gmail.com', NULL, 'user', '1', '1', '1', NULL, 203, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(212, '', '00140', '@gmail.com.16@gmail.com', NULL, 'user', '1', '1', '1', NULL, 204, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(213, '', '00141', '@gmail.com.17@gmail.com', NULL, 'user', '1', '1', '1', NULL, 205, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(214, '', '00142', '@gmail.com.18@gmail.com', NULL, 'user', '1', '1', '1', NULL, 206, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(215, '', '00143', '@gmail.com.19@gmail.com', NULL, 'user', '1', '1', '1', NULL, 207, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(216, '', '00144', '@gmail.com.20@gmail.com', NULL, 'user', '1', '1', '1', NULL, 208, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(217, '', '00145', '@gmail.com.21@gmail.com', NULL, 'user', '1', '1', '1', NULL, 209, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(218, '', '00146', '@gmail.com.22@gmail.com', NULL, 'user', '1', '1', '1', NULL, 210, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(219, '', '00147', '@gmail.com.23@gmail.com', NULL, 'user', '1', '1', '1', NULL, 211, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(220, '', '00148', '@gmail.com.24@gmail.com', NULL, 'user', '1', '1', '1', NULL, 212, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(221, '', '00149', '@gmail.com.25@gmail.com', NULL, 'user', '1', '1', '1', NULL, 213, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(222, '', '00150', '@gmail.com.26@gmail.com', NULL, 'user', '1', '1', '1', NULL, 214, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(223, '', '00151', '@gmail.com.27@gmail.com', NULL, 'user', '1', '1', '1', NULL, 215, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(224, '', '00152', '@gmail.com.28@gmail.com', NULL, 'user', '1', '1', '1', NULL, 216, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(225, '', '00153', '@gmail.com.29@gmail.com', NULL, 'user', '1', '1', '1', NULL, 217, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(226, '', '00154', '@gmail.com.30@gmail.com', NULL, 'user', '1', '1', '1', NULL, 218, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(227, '', '00155', '@gmail.com.31@gmail.com', NULL, 'user', '1', '1', '1', NULL, 219, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(228, '', '00156', '@gmail.com.32@gmail.com', NULL, 'user', '1', '1', '1', NULL, 220, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(229, '', '00157', '@gmail.com.33@gmail.com', NULL, 'user', '1', '1', '1', NULL, 221, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(230, '', '00158', '@gmail.com.34@gmail.com', NULL, 'user', '1', '1', '1', NULL, 222, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(231, '', '00159', '@gmail.com.35@gmail.com', NULL, 'user', '1', '1', '1', NULL, 223, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(232, '', '00160', '@gmail.com.36@gmail.com', NULL, 'user', '1', '1', '1', NULL, 224, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(233, '', '00161', '@gmail.com.37@gmail.com', NULL, 'user', '1', '1', '1', NULL, 225, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:37', '2025-05-19 12:13:37'),
(234, '', '00162', '@gmail.com.38@gmail.com', NULL, 'user', '1', '1', '1', NULL, 226, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(235, '', '00163', '@gmail.com.39@gmail.com', NULL, 'user', '1', '1', '1', NULL, 227, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(236, '', '00164', '@gmail.com.40@gmail.com', NULL, 'user', '1', '1', '1', NULL, 228, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(237, '', '00165', '@gmail.com.41@gmail.com', NULL, 'user', '1', '1', '1', NULL, 229, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(238, '', '00166', '@gmail.com.42@gmail.com', NULL, 'user', '1', '1', '1', NULL, 230, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(239, '', '00167', '@gmail.com.43@gmail.com', NULL, 'user', '1', '1', '1', NULL, 231, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(240, '', '00168', '@gmail.com.44@gmail.com', NULL, 'user', '1', '1', '1', NULL, 232, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(241, '', '00169', '@gmail.com.45@gmail.com', NULL, 'user', '1', '1', '1', NULL, 233, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(242, '', '00170', '@gmail.com.46@gmail.com', NULL, 'user', '1', '1', '1', NULL, 234, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(243, '', '00171', '@gmail.com.47@gmail.com', NULL, 'user', '1', '1', '1', NULL, 235, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(244, '', '00172', '@gmail.com.48@gmail.com', NULL, 'user', '1', '1', '1', NULL, 236, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(245, '', '00173', '@gmail.com.49@gmail.com', NULL, 'user', '1', '1', '1', NULL, 237, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(246, '', '00174', '@gmail.com.50@gmail.com', NULL, 'user', '1', '1', '1', NULL, 238, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(247, '', '00175', '@gmail.com.51@gmail.com', NULL, 'user', '1', '1', '1', NULL, 239, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(248, '', '00176', '@gmail.com.52@gmail.com', NULL, 'user', '1', '1', '1', NULL, 240, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(249, '', '00177', '@gmail.com.53@gmail.com', NULL, 'user', '1', '1', '1', NULL, 241, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(250, '', '00178', '@gmail.com.54@gmail.com', NULL, 'user', '1', '1', '1', NULL, 242, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(251, '', '00179', '@gmail.com.55@gmail.com', NULL, 'user', '1', '1', '1', NULL, 243, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(252, '', '00180', '@gmail.com.56@gmail.com', NULL, 'user', '1', '1', '1', NULL, 244, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(253, '', '00181', '@gmail.com.57@gmail.com', NULL, 'user', '1', '1', '1', NULL, 245, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(254, '', '00182', '@gmail.com.58@gmail.com', NULL, 'user', '1', '1', '1', NULL, 246, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:38', '2025-05-19 12:13:38'),
(255, '', '00183', '@gmail.com.59@gmail.com', NULL, 'user', '1', '1', '1', NULL, 247, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(256, '', '00184', '@gmail.com.60@gmail.com', NULL, 'user', '1', '1', '1', NULL, 248, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(257, '', '00185', '@gmail.com.61@gmail.com', NULL, 'user', '1', '1', '1', NULL, 249, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(258, '', '00186', '@gmail.com.62@gmail.com', NULL, 'user', '1', '1', '1', NULL, 250, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(259, '', '00187', '@gmail.com.63@gmail.com', NULL, 'user', '1', '1', '1', NULL, 251, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(260, '', '00188', '@gmail.com.64@gmail.com', NULL, 'user', '1', '1', '1', NULL, 252, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(261, '', '00189', '@gmail.com.65@gmail.com', NULL, 'user', '1', '1', '1', NULL, 253, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(262, '', '00190', '@gmail.com.66@gmail.com', NULL, 'user', '1', '1', '1', NULL, 254, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(263, '', '00191', '@gmail.com.67@gmail.com', NULL, 'user', '1', '1', '1', NULL, 255, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(264, '', '00192', '@gmail.com.68@gmail.com', NULL, 'user', '1', '1', '1', NULL, 256, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(265, '', '00193', '@gmail.com.69@gmail.com', NULL, 'user', '1', '1', '1', NULL, 257, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(266, '', '00194', '@gmail.com.70@gmail.com', NULL, 'user', '1', '1', '1', NULL, 258, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(267, '', '00195', '@gmail.com.71@gmail.com', NULL, 'user', '1', '1', '1', NULL, 259, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(268, '', '00196', '@gmail.com.72@gmail.com', NULL, 'user', '1', '1', '1', NULL, 260, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(269, '', '00197', '@gmail.com.73@gmail.com', NULL, 'user', '1', '1', '1', NULL, 261, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(270, '', '00198', '@gmail.com.74@gmail.com', NULL, 'user', '1', '1', '1', NULL, 262, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(271, '', '00199', '@gmail.com.75@gmail.com', NULL, 'user', '1', '1', '1', NULL, 263, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(272, '', '00200', '@gmail.com.76@gmail.com', NULL, 'user', '1', '1', '1', NULL, 264, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(273, '', '00201', '@gmail.com.77@gmail.com', NULL, 'user', '1', '1', '1', NULL, 265, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:39', '2025-05-19 12:13:39'),
(274, '', '00202', '@gmail.com.78@gmail.com', NULL, 'user', '1', '1', '1', NULL, 266, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(275, '', '00203', '@gmail.com.79@gmail.com', NULL, 'user', '1', '1', '1', NULL, 267, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(276, '', '00204', '@gmail.com.80@gmail.com', NULL, 'user', '1', '1', '1', NULL, 268, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(277, '', '00205', '@gmail.com.81@gmail.com', NULL, 'user', '1', '1', '1', NULL, 269, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(278, '', '00206', '@gmail.com.82@gmail.com', NULL, 'user', '1', '1', '1', NULL, 270, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(279, '', '00207', '@gmail.com.83@gmail.com', NULL, 'user', '1', '1', '1', NULL, 271, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(280, '', '00208', '@gmail.com.84@gmail.com', NULL, 'user', '1', '1', '1', NULL, 272, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(281, '', '00209', '@gmail.com.85@gmail.com', NULL, 'user', '1', '1', '1', NULL, 273, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(282, '', '00210', '@gmail.com.86@gmail.com', NULL, 'user', '1', '1', '1', NULL, 274, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(283, '', '00211', '@gmail.com.87@gmail.com', NULL, 'user', '1', '1', '1', NULL, 275, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(284, '', '00212', '@gmail.com.88@gmail.com', NULL, 'user', '1', '1', '1', NULL, 276, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(285, '', '00213', '@gmail.com.89@gmail.com', NULL, 'user', '1', '1', '1', NULL, 277, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(286, '', '00214', '@gmail.com.90@gmail.com', NULL, 'user', '1', '1', '1', NULL, 278, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(287, '', '00215', '@gmail.com.91@gmail.com', NULL, 'user', '1', '1', '1', NULL, 279, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(288, '', '00216', '@gmail.com.92@gmail.com', NULL, 'user', '1', '1', '1', NULL, 280, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(289, '', '00217', '@gmail.com.93@gmail.com', NULL, 'user', '1', '1', '1', NULL, 281, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(290, '', '00218', '@gmail.com.94@gmail.com', NULL, 'user', '1', '1', '1', NULL, 282, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:40', '2025-05-19 12:13:40'),
(291, '', '00219', '@gmail.com.95@gmail.com', NULL, 'user', '1', '1', '1', NULL, 283, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(292, '', '00220', '@gmail.com.96@gmail.com', NULL, 'user', '1', '1', '1', NULL, 284, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(293, '', '00221', '@gmail.com.97@gmail.com', NULL, 'user', '1', '1', '1', NULL, 285, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(294, '', '00222', '@gmail.com.98@gmail.com', NULL, 'user', '1', '1', '1', NULL, 286, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(295, '', '00223', '@gmail.com.99@gmail.com', NULL, 'user', '1', '1', '1', NULL, 287, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(296, '', '00224', '@gmail.com.100@gmail.com', NULL, 'user', '1', '1', '1', NULL, 288, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(297, '', '00225', '@gmail.com.101@gmail.com', NULL, 'user', '1', '1', '1', NULL, 289, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(298, '', '00226', '@gmail.com.102@gmail.com', NULL, 'user', '1', '1', '1', NULL, 290, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(299, '', '00227', '@gmail.com.103@gmail.com', NULL, 'user', '1', '1', '1', NULL, 291, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(300, '', '00228', '@gmail.com.104@gmail.com', NULL, 'user', '1', '1', '1', NULL, 292, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(301, '', '00229', '@gmail.com.105@gmail.com', NULL, 'user', '1', '1', '1', NULL, 293, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(302, '', '00230', '@gmail.com.106@gmail.com', NULL, 'user', '1', '1', '1', NULL, 294, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(303, '', '00231', '@gmail.com.107@gmail.com', NULL, 'user', '1', '1', '1', NULL, 295, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(304, '', '00232', '@gmail.com.108@gmail.com', NULL, 'user', '1', '1', '1', NULL, 296, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(305, '', '00233', '@gmail.com.109@gmail.com', NULL, 'user', '1', '1', '1', NULL, 297, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(306, '', '00234', '@gmail.com.110@gmail.com', NULL, 'user', '1', '1', '1', NULL, 298, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(307, '', '00235', '@gmail.com.111@gmail.com', NULL, 'user', '1', '1', '1', NULL, 299, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:41', '2025-05-19 12:13:41'),
(308, '', '00236', '@gmail.com.112@gmail.com', NULL, 'user', '1', '1', '1', NULL, 300, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(309, '', '00237', '@gmail.com.113@gmail.com', NULL, 'user', '1', '1', '1', NULL, 301, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(310, '', '00238', '@gmail.com.114@gmail.com', NULL, 'user', '1', '1', '1', NULL, 302, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(311, '', '00239', '@gmail.com.115@gmail.com', NULL, 'user', '1', '1', '1', NULL, 303, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(312, '', '00240', '@gmail.com.116@gmail.com', NULL, 'user', '1', '1', '1', NULL, 304, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(313, '', '00241', '@gmail.com.117@gmail.com', NULL, 'user', '1', '1', '1', NULL, 305, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(314, '', '00242', '@gmail.com.118@gmail.com', NULL, 'user', '1', '1', '1', NULL, 306, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(315, '', '00243', '@gmail.com.119@gmail.com', NULL, 'user', '1', '1', '1', NULL, 307, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(316, '', '00244', '@gmail.com.120@gmail.com', NULL, 'user', '1', '1', '1', NULL, 308, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(317, '', '00245', '@gmail.com.121@gmail.com', NULL, 'user', '1', '1', '1', NULL, 309, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(318, '', '00246', '@gmail.com.122@gmail.com', NULL, 'user', '1', '1', '1', NULL, 310, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(319, '', '00247', '@gmail.com.123@gmail.com', NULL, 'user', '1', '1', '1', NULL, 311, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(320, '', '00248', '@gmail.com.124@gmail.com', NULL, 'user', '1', '1', '1', NULL, 312, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(321, '', '00249', '@gmail.com.125@gmail.com', NULL, 'user', '1', '1', '1', NULL, 313, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(322, '', '00250', '@gmail.com.126@gmail.com', NULL, 'user', '1', '1', '1', NULL, 314, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:42', '2025-05-19 12:13:42'),
(323, '', '00251', '@gmail.com.127@gmail.com', NULL, 'user', '1', '1', '1', NULL, 315, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(324, '', '00252', '@gmail.com.128@gmail.com', NULL, 'user', '1', '1', '1', NULL, 316, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(325, '', '00253', '@gmail.com.129@gmail.com', NULL, 'user', '1', '1', '1', NULL, 317, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(326, '', '00254', '@gmail.com.130@gmail.com', NULL, 'user', '1', '1', '1', NULL, 318, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(327, '', '00255', '@gmail.com.131@gmail.com', NULL, 'user', '1', '1', '1', NULL, 319, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(328, '', '00256', '@gmail.com.132@gmail.com', NULL, 'user', '1', '1', '1', NULL, 320, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(329, '', '00257', '@gmail.com.133@gmail.com', NULL, 'user', '1', '1', '1', NULL, 321, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(330, '', '00258', '@gmail.com.134@gmail.com', NULL, 'user', '1', '1', '1', NULL, 322, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(331, '', '00259', '@gmail.com.135@gmail.com', NULL, 'user', '1', '1', '1', NULL, 323, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(332, '', '00260', '@gmail.com.136@gmail.com', NULL, 'user', '1', '1', '1', NULL, 324, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(333, '', '00261', '@gmail.com.137@gmail.com', NULL, 'user', '1', '1', '1', NULL, 325, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(334, '', '00262', '@gmail.com.138@gmail.com', NULL, 'user', '1', '1', '1', NULL, 326, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(335, '', '00263', '@gmail.com.139@gmail.com', NULL, 'user', '1', '1', '1', NULL, 327, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:43', '2025-05-19 12:13:43'),
(336, '', '00264', '@gmail.com.140@gmail.com', NULL, 'user', '1', '1', '1', NULL, 328, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(337, '', '00265', '@gmail.com.141@gmail.com', NULL, 'user', '1', '1', '1', NULL, 329, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(338, '', '00266', '@gmail.com.142@gmail.com', NULL, 'user', '1', '1', '1', NULL, 330, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(339, '', '00267', '@gmail.com.143@gmail.com', NULL, 'user', '1', '1', '1', NULL, 331, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(340, '', '00268', '@gmail.com.144@gmail.com', NULL, 'user', '1', '1', '1', NULL, 332, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(341, '', '00269', '@gmail.com.145@gmail.com', NULL, 'user', '1', '1', '1', NULL, 333, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(342, '', '00270', '@gmail.com.146@gmail.com', NULL, 'user', '1', '1', '1', NULL, 334, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(343, '', '00271', '@gmail.com.147@gmail.com', NULL, 'user', '1', '1', '1', NULL, 335, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(344, '', '00272', '@gmail.com.148@gmail.com', NULL, 'user', '1', '1', '1', NULL, 336, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(345, '', '00273', '@gmail.com.149@gmail.com', NULL, 'user', '1', '1', '1', NULL, 337, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(346, '', '00274', '@gmail.com.150@gmail.com', NULL, 'user', '1', '1', '1', NULL, 338, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(347, '', '00275', '@gmail.com.151@gmail.com', NULL, 'user', '1', '1', '1', NULL, 339, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:44', '2025-05-19 12:13:44'),
(348, '', '00276', '@gmail.com.152@gmail.com', NULL, 'user', '1', '1', '1', NULL, 340, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(349, '', '00277', '@gmail.com.153@gmail.com', NULL, 'user', '1', '1', '1', NULL, 341, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(350, '', '00278', '@gmail.com.154@gmail.com', NULL, 'user', '1', '1', '1', NULL, 342, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(351, '', '00279', '@gmail.com.155@gmail.com', NULL, 'user', '1', '1', '1', NULL, 343, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(352, '', '00280', '@gmail.com.156@gmail.com', NULL, 'user', '1', '1', '1', NULL, 344, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(353, '', '00281', '@gmail.com.157@gmail.com', NULL, 'user', '1', '1', '1', NULL, 345, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(354, '', '00282', '@gmail.com.158@gmail.com', NULL, 'user', '1', '1', '1', NULL, 346, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(355, '', '00283', '@gmail.com.159@gmail.com', NULL, 'user', '1', '1', '1', NULL, 347, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(356, '', '00284', '@gmail.com.160@gmail.com', NULL, 'user', '1', '1', '1', NULL, 348, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(357, '', '00285', '@gmail.com.161@gmail.com', NULL, 'user', '1', '1', '1', NULL, 349, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(358, '', '00286', '@gmail.com.162@gmail.com', NULL, 'user', '1', '1', '1', NULL, 350, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:45', '2025-05-19 12:13:45'),
(359, '', '00287', '@gmail.com.163@gmail.com', NULL, 'user', '1', '1', '1', NULL, 351, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(360, '', '00288', '@gmail.com.164@gmail.com', NULL, 'user', '1', '1', '1', NULL, 352, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(361, '', '00289', '@gmail.com.165@gmail.com', NULL, 'user', '1', '1', '1', NULL, 353, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(362, '', '00290', '@gmail.com.166@gmail.com', NULL, 'user', '1', '1', '1', NULL, 354, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(363, '', '00291', '@gmail.com.167@gmail.com', NULL, 'user', '1', '1', '1', NULL, 355, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(364, '', '00292', '@gmail.com.168@gmail.com', NULL, 'user', '1', '1', '1', NULL, 356, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(365, '', '00293', '@gmail.com.169@gmail.com', NULL, 'user', '1', '1', '1', NULL, 357, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(366, '', '00294', '@gmail.com.170@gmail.com', NULL, 'user', '1', '1', '1', NULL, 358, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(367, '', '00295', '@gmail.com.171@gmail.com', NULL, 'user', '1', '1', '1', NULL, 359, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(368, '', '00296', '@gmail.com.172@gmail.com', NULL, 'user', '1', '1', '1', NULL, 360, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(369, '', '00297', '@gmail.com.173@gmail.com', NULL, 'user', '1', '1', '1', NULL, 361, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:46', '2025-05-19 12:13:46'),
(370, '', '00298', '@gmail.com.174@gmail.com', NULL, 'user', '1', '1', '1', NULL, 362, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47');
INSERT INTO `users` (`id`, `name`, `user_name`, `email`, `image`, `user_type`, `organization_ids`, `branch_ids`, `cost_center_ids`, `store_ids`, `ref_id`, `email_verified_at`, `password`, `status`, `_is_delete`, `_ac_type`, `remember_token`, `created_at`, `updated_at`) VALUES
(371, '', '00299', '@gmail.com.175@gmail.com', NULL, 'user', '1', '1', '1', NULL, 363, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(372, '', '00300', '@gmail.com.176@gmail.com', NULL, 'user', '1', '1', '1', NULL, 364, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(373, '', '00301', '@gmail.com.177@gmail.com', NULL, 'user', '1', '1', '1', NULL, 365, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(374, '', '00302', '@gmail.com.178@gmail.com', NULL, 'user', '1', '1', '1', NULL, 366, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(375, '', '00303', '@gmail.com.179@gmail.com', NULL, 'user', '1', '1', '1', NULL, 367, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(376, '', '00304', '@gmail.com.180@gmail.com', NULL, 'user', '1', '1', '1', NULL, 368, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(377, '', '00305', '@gmail.com.181@gmail.com', NULL, 'user', '1', '1', '1', NULL, 369, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(378, '', '00306', '@gmail.com.182@gmail.com', NULL, 'user', '1', '1', '1', NULL, 370, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(379, '', '00307', '@gmail.com.183@gmail.com', NULL, 'user', '1', '1', '1', NULL, 371, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(380, '', '00308', '@gmail.com.184@gmail.com', NULL, 'user', '1', '1', '1', NULL, 372, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:47', '2025-05-19 12:13:47'),
(381, '', '00309', '@gmail.com.185@gmail.com', NULL, 'user', '1', '1', '1', NULL, 373, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(382, '', '00310', '@gmail.com.186@gmail.com', NULL, 'user', '1', '1', '1', NULL, 374, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(383, '', '00311', '@gmail.com.187@gmail.com', NULL, 'user', '1', '1', '1', NULL, 375, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(384, '', '00312', '@gmail.com.188@gmail.com', NULL, 'user', '1', '1', '1', NULL, 376, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(385, '', '00313', '@gmail.com.189@gmail.com', NULL, 'user', '1', '1', '1', NULL, 377, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(386, '', '00314', '@gmail.com.190@gmail.com', NULL, 'user', '1', '1', '1', NULL, 378, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(387, '', '00315', '@gmail.com.191@gmail.com', NULL, 'user', '1', '1', '1', NULL, 379, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(388, '', '00316', '@gmail.com.192@gmail.com', NULL, 'user', '1', '1', '1', NULL, 380, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(389, '', '00317', '@gmail.com.193@gmail.com', NULL, 'user', '1', '1', '1', NULL, 381, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(390, '', '00318', '@gmail.com.194@gmail.com', NULL, 'user', '1', '1', '1', NULL, 382, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:48', '2025-05-19 12:13:48'),
(391, '', '00319', '@gmail.com.195@gmail.com', NULL, 'user', '1', '1', '1', NULL, 383, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(392, '', '00320', '@gmail.com.196@gmail.com', NULL, 'user', '1', '1', '1', NULL, 384, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(393, '', '00321', '@gmail.com.197@gmail.com', NULL, 'user', '1', '1', '1', NULL, 385, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(394, '', '00322', '@gmail.com.198@gmail.com', NULL, 'user', '1', '1', '1', NULL, 386, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(395, '', '00323', '@gmail.com.199@gmail.com', NULL, 'user', '1', '1', '1', NULL, 387, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(396, '', '00324', '@gmail.com.200@gmail.com', NULL, 'user', '1', '1', '1', NULL, 388, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(397, '', '00325', '@gmail.com.201@gmail.com', NULL, 'user', '1', '1', '1', NULL, 389, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(398, '', '00326', '@gmail.com.202@gmail.com', NULL, 'user', '1', '1', '1', NULL, 390, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(399, '', '00327', '@gmail.com.203@gmail.com', NULL, 'user', '1', '1', '1', NULL, 391, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(400, '', '00328', '@gmail.com.204@gmail.com', NULL, 'user', '1', '1', '1', NULL, 392, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(401, '', '00329', '@gmail.com.205@gmail.com', NULL, 'user', '1', '1', '1', NULL, 393, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:49', '2025-05-19 12:13:49'),
(402, '', '00330', '@gmail.com.206@gmail.com', NULL, 'user', '1', '1', '1', NULL, 394, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50'),
(403, '', '00331', '@gmail.com.207@gmail.com', NULL, 'user', '1', '1', '1', NULL, 395, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50'),
(404, '', '00332', '@gmail.com.208@gmail.com', NULL, 'user', '1', '1', '1', NULL, 396, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50'),
(405, '', '00333', '@gmail.com.209@gmail.com', NULL, 'user', '1', '1', '1', NULL, 397, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50'),
(406, '', '00334', '@gmail.com.210@gmail.com', NULL, 'user', '1', '1', '1', NULL, 398, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50'),
(407, '', '00335', '@gmail.com.211@gmail.com', NULL, 'user', '1', '1', '1', NULL, 399, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50'),
(408, '', '00336', '@gmail.com.212@gmail.com', NULL, 'user', '1', '1', '1', NULL, 400, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50'),
(409, '', '00337', '@gmail.com.213@gmail.com', NULL, 'user', '1', '1', '1', NULL, 401, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50'),
(410, '', '00338', '@gmail.com.214@gmail.com', NULL, 'user', '1', '1', '1', NULL, 402, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:50', '2025-05-19 12:13:50'),
(411, '', '00339', '@gmail.com.215@gmail.com', NULL, 'user', '1', '1', '1', NULL, 403, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51'),
(412, '', '00340', '@gmail.com.216@gmail.com', NULL, 'user', '1', '1', '1', NULL, 404, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51'),
(413, '', '00341', '@gmail.com.217@gmail.com', NULL, 'user', '1', '1', '1', NULL, 405, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51'),
(414, '', '00342', '@gmail.com.218@gmail.com', NULL, 'user', '1', '1', '1', NULL, 406, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51'),
(415, '', '00343', '@gmail.com.219@gmail.com', NULL, 'user', '1', '1', '1', NULL, 407, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51'),
(416, '', '00344', '@gmail.com.220@gmail.com', NULL, 'user', '1', '1', '1', NULL, 408, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51'),
(417, '', '00345', '@gmail.com.221@gmail.com', NULL, 'user', '1', '1', '1', NULL, 409, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51'),
(418, '', '00346', '@gmail.com.222@gmail.com', NULL, 'user', '1', '1', '1', NULL, 410, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51'),
(419, '', '00347', '@gmail.com.223@gmail.com', NULL, 'user', '1', '1', '1', NULL, 411, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:51', '2025-05-19 12:13:51'),
(420, '', '00348', '@gmail.com.224@gmail.com', NULL, 'user', '1', '1', '1', NULL, 412, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(421, '', '00349', '@gmail.com.225@gmail.com', NULL, 'user', '1', '1', '1', NULL, 413, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(422, '', '00350', '@gmail.com.226@gmail.com', NULL, 'user', '1', '1', '1', NULL, 414, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(423, '', '00351', '@gmail.com.227@gmail.com', NULL, 'user', '1', '1', '1', NULL, 415, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(424, '', '00352', '@gmail.com.228@gmail.com', NULL, 'user', '1', '1', '1', NULL, 416, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(425, '', '00353', '@gmail.com.229@gmail.com', NULL, 'user', '1', '1', '1', NULL, 417, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(426, '', '00354', '@gmail.com.230@gmail.com', NULL, 'user', '1', '1', '1', NULL, 418, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(427, '', '00355', '@gmail.com.231@gmail.com', NULL, 'user', '1', '1', '1', NULL, 419, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(428, '', '00356', '@gmail.com.232@gmail.com', NULL, 'user', '1', '1', '1', NULL, 420, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(429, '', '00357', '@gmail.com.233@gmail.com', NULL, 'user', '1', '1', '1', NULL, 421, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(430, '', '00358', '@gmail.com.234@gmail.com', NULL, 'user', '1', '1', '1', NULL, 422, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:52', '2025-05-19 12:13:52'),
(431, '', '00359', '@gmail.com.235@gmail.com', NULL, 'user', '1', '1', '1', NULL, 423, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53'),
(432, '', '00360', '@gmail.com.236@gmail.com', NULL, 'user', '1', '1', '1', NULL, 424, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53'),
(433, '', '00361', '@gmail.com.237@gmail.com', NULL, 'user', '1', '1', '1', NULL, 425, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53'),
(434, '', '00362', '@gmail.com.238@gmail.com', NULL, 'user', '1', '1', '1', NULL, 426, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53'),
(435, '', '00363', '@gmail.com.239@gmail.com', NULL, 'user', '1', '1', '1', NULL, 427, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53'),
(436, '', '00364', '@gmail.com.240@gmail.com', NULL, 'user', '1', '1', '1', NULL, 428, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53'),
(437, '', '00365', '@gmail.com.241@gmail.com', NULL, 'user', '1', '1', '1', NULL, 429, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53'),
(438, '', '00366', '@gmail.com.242@gmail.com', NULL, 'user', '1', '1', '1', NULL, 430, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53'),
(439, '', '00367', '@gmail.com.243@gmail.com', NULL, 'user', '1', '1', '1', NULL, 431, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:53', '2025-05-19 12:13:53'),
(440, '', '00368', '@gmail.com.244@gmail.com', NULL, 'user', '1', '1', '1', NULL, 432, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54'),
(441, '', '00369', '@gmail.com.245@gmail.com', NULL, 'user', '1', '1', '1', NULL, 433, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54'),
(442, '', '00370', '@gmail.com.246@gmail.com', NULL, 'user', '1', '1', '1', NULL, 434, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54'),
(443, '', '00371', '@gmail.com.247@gmail.com', NULL, 'user', '1', '1', '1', NULL, 435, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54'),
(444, '', '00372', '@gmail.com.248@gmail.com', NULL, 'user', '1', '1', '1', NULL, 436, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54'),
(445, '', '00373', '@gmail.com.249@gmail.com', NULL, 'user', '1', '1', '1', NULL, 437, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54'),
(446, '', '00374', '@gmail.com.250@gmail.com', NULL, 'user', '1', '1', '1', NULL, 438, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54'),
(447, '', '00375', '@gmail.com.251@gmail.com', NULL, 'user', '1', '1', '1', NULL, 439, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:54', '2025-05-19 12:13:54'),
(448, '', '00376', '@gmail.com.252@gmail.com', NULL, 'user', '1', '1', '1', NULL, 440, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55'),
(449, '', '00377', '@gmail.com.253@gmail.com', NULL, 'user', '1', '1', '1', NULL, 441, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55'),
(450, '', '00378', '@gmail.com.254@gmail.com', NULL, 'user', '1', '1', '1', NULL, 442, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55'),
(451, '', '00379', '@gmail.com.255@gmail.com', NULL, 'user', '1', '1', '1', NULL, 443, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55'),
(452, '', '00380', '@gmail.com.256@gmail.com', NULL, 'user', '1', '1', '1', NULL, 444, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55'),
(453, '', '00381', '@gmail.com.257@gmail.com', NULL, 'user', '1', '1', '1', NULL, 445, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55'),
(454, '', '00382', '@gmail.com.258@gmail.com', NULL, 'user', '1', '1', '1', NULL, 446, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55'),
(455, '', '00383', '@gmail.com.259@gmail.com', NULL, 'user', '1', '1', '1', NULL, 447, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55'),
(456, '', '00384', '@gmail.com.260@gmail.com', NULL, 'user', '1', '1', '1', NULL, 448, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:55', '2025-05-19 12:13:55'),
(457, '', '00385', '@gmail.com.261@gmail.com', NULL, 'user', '1', '1', '1', NULL, 449, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56'),
(458, '', '00386', '@gmail.com.262@gmail.com', NULL, 'user', '1', '1', '1', NULL, 450, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56'),
(459, '', '00387', '@gmail.com.263@gmail.com', NULL, 'user', '1', '1', '1', NULL, 451, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56'),
(460, '', '00388', '@gmail.com.264@gmail.com', NULL, 'user', '1', '1', '1', NULL, 452, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56'),
(461, '', '00389', '@gmail.com.265@gmail.com', NULL, 'user', '1', '1', '1', NULL, 453, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56'),
(462, '', '00390', '@gmail.com.266@gmail.com', NULL, 'user', '1', '1', '1', NULL, 454, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56'),
(463, '', '00391', '@gmail.com.267@gmail.com', NULL, 'user', '1', '1', '1', NULL, 455, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56'),
(464, '', '00392', '@gmail.com.268@gmail.com', NULL, 'user', '1', '1', '1', NULL, 456, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:56', '2025-05-19 12:13:56'),
(465, '', '00393', '@gmail.com.269@gmail.com', NULL, 'user', '1', '1', '1', NULL, 457, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57'),
(466, '', '00394', '@gmail.com.270@gmail.com', NULL, 'user', '1', '1', '1', NULL, 458, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57'),
(467, '', '00395', '@gmail.com.271@gmail.com', NULL, 'user', '1', '1', '1', NULL, 459, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57'),
(468, '', '00396', '@gmail.com.272@gmail.com', NULL, 'user', '1', '1', '1', NULL, 460, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57'),
(469, '', '00397', '@gmail.com.273@gmail.com', NULL, 'user', '1', '1', '1', NULL, 461, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57'),
(470, '', '00398', '@gmail.com.274@gmail.com', NULL, 'user', '1', '1', '1', NULL, 462, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57'),
(471, '', '00399', '@gmail.com.275@gmail.com', NULL, 'user', '1', '1', '1', NULL, 463, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57'),
(472, '', '00400', '@gmail.com.276@gmail.com', NULL, 'user', '1', '1', '1', NULL, 464, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:57', '2025-05-19 12:13:57'),
(473, '', '00401', '@gmail.com.277@gmail.com', NULL, 'user', '1', '1', '1', NULL, 465, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58'),
(474, '', '00402', '@gmail.com.278@gmail.com', NULL, 'user', '1', '1', '1', NULL, 466, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58'),
(475, '', '00403', '@gmail.com.279@gmail.com', NULL, 'user', '1', '1', '1', NULL, 467, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58'),
(476, '', '00404', '@gmail.com.280@gmail.com', NULL, 'user', '1', '1', '1', NULL, 468, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58'),
(477, '', '00405', '@gmail.com.281@gmail.com', NULL, 'user', '1', '1', '1', NULL, 469, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58'),
(478, '', '00406', '@gmail.com.282@gmail.com', NULL, 'user', '1', '1', '1', NULL, 470, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58'),
(479, '', '00407', '@gmail.com.283@gmail.com', NULL, 'user', '1', '1', '1', NULL, 471, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:58', '2025-05-19 12:13:58'),
(480, '', '00408', '@gmail.com.284@gmail.com', NULL, 'user', '1', '1', '1', NULL, 472, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59'),
(481, '', '00409', '@gmail.com.285@gmail.com', NULL, 'user', '1', '1', '1', NULL, 473, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59'),
(482, '', '00410', '@gmail.com.286@gmail.com', NULL, 'user', '1', '1', '1', NULL, 474, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59'),
(483, '', '00411', '@gmail.com.287@gmail.com', NULL, 'user', '1', '1', '1', NULL, 475, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59'),
(484, '', '00412', '@gmail.com.288@gmail.com', NULL, 'user', '1', '1', '1', NULL, 476, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59'),
(485, '', '00413', '@gmail.com.289@gmail.com', NULL, 'user', '1', '1', '1', NULL, 477, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59'),
(486, '', '00414', '@gmail.com.290@gmail.com', NULL, 'user', '1', '1', '1', NULL, 478, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:13:59', '2025-05-19 12:13:59'),
(487, '', '00415', '@gmail.com.291@gmail.com', NULL, 'user', '1', '1', '1', NULL, 479, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00'),
(488, '', '00416', '@gmail.com.292@gmail.com', NULL, 'user', '1', '1', '1', NULL, 480, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00'),
(489, '', '00417', '@gmail.com.293@gmail.com', NULL, 'user', '1', '1', '1', NULL, 481, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00'),
(490, '', '00418', '@gmail.com.294@gmail.com', NULL, 'user', '1', '1', '1', NULL, 482, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00'),
(491, '', '00419', '@gmail.com.295@gmail.com', NULL, 'user', '1', '1', '1', NULL, 483, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00'),
(492, '', '00420', '@gmail.com.296@gmail.com', NULL, 'user', '1', '1', '1', NULL, 484, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00'),
(493, '', '00421', '@gmail.com.297@gmail.com', NULL, 'user', '1', '1', '1', NULL, 485, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:00', '2025-05-19 12:14:00'),
(494, '', '00422', '@gmail.com.298@gmail.com', NULL, 'user', '1', '1', '1', NULL, 486, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01'),
(495, '', '00423', '@gmail.com.299@gmail.com', NULL, 'user', '1', '1', '1', NULL, 487, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01'),
(496, '', '00424', '@gmail.com.300@gmail.com', NULL, 'user', '1', '1', '1', NULL, 488, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01'),
(497, '', '00425', '@gmail.com.301@gmail.com', NULL, 'user', '1', '1', '1', NULL, 489, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01'),
(498, '', '00426', '@gmail.com.302@gmail.com', NULL, 'user', '1', '1', '1', NULL, 490, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01'),
(499, '', '00427', '@gmail.com.303@gmail.com', NULL, 'user', '1', '1', '1', NULL, 491, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:01', '2025-05-19 12:14:01'),
(500, '', '00428', '@gmail.com.304@gmail.com', NULL, 'user', '1', '1', '1', NULL, 492, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02'),
(501, '', '00429', '@gmail.com.305@gmail.com', NULL, 'user', '1', '1', '1', NULL, 493, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02'),
(502, '', '00430', '@gmail.com.306@gmail.com', NULL, 'user', '1', '1', '1', NULL, 494, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02'),
(503, '', '00431', '@gmail.com.307@gmail.com', NULL, 'user', '1', '1', '1', NULL, 495, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02'),
(504, '', '00432', '@gmail.com.308@gmail.com', NULL, 'user', '1', '1', '1', NULL, 496, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:02', '2025-05-19 12:14:02'),
(505, '', '00433', '@gmail.com.309@gmail.com', NULL, 'user', '1', '1', '1', NULL, 497, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03'),
(506, '', '00434', '@gmail.com.310@gmail.com', NULL, 'user', '1', '1', '1', NULL, 498, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03'),
(507, '', '00435', '@gmail.com.311@gmail.com', NULL, 'user', '1', '1', '1', NULL, 499, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03'),
(508, '', '00436', '@gmail.com.312@gmail.com', NULL, 'user', '1', '1', '1', NULL, 500, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03'),
(509, '', '00437', '@gmail.com.313@gmail.com', NULL, 'user', '1', '1', '1', NULL, 501, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03'),
(510, '', '00438', '@gmail.com.314@gmail.com', NULL, 'user', '1', '1', '1', NULL, 502, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:03', '2025-05-19 12:14:03'),
(511, '', '00439', '@gmail.com.315@gmail.com', NULL, 'user', '1', '1', '1', NULL, 503, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04'),
(512, '', '00440', '@gmail.com.316@gmail.com', NULL, 'user', '1', '1', '1', NULL, 504, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04'),
(513, '', '00441', '@gmail.com.317@gmail.com', NULL, 'user', '1', '1', '1', NULL, 505, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04'),
(514, '', '00442', '@gmail.com.318@gmail.com', NULL, 'user', '1', '1', '1', NULL, 506, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04'),
(515, '', '00443', '@gmail.com.319@gmail.com', NULL, 'user', '1', '1', '1', NULL, 507, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04'),
(516, '', '00444', '@gmail.com.320@gmail.com', NULL, 'user', '1', '1', '1', NULL, 508, NULL, '', 1, 0, 0, NULL, '2025-05-19 12:14:04', '2025-05-19 12:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `users_erp`
--

CREATE TABLE `users_erp` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `department_id` int(11) NOT NULL DEFAULT 0,
  `project_id` int(11) NOT NULL,
  `office_id` varchar(550) DEFAULT NULL,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(50) NOT NULL,
  `store_id` int(11) NOT NULL,
  `designation` varchar(650) DEFAULT NULL,
  `role_name` varchar(250) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_number` varchar(100) DEFAULT NULL,
  `profile_image` varchar(650) DEFAULT NULL,
  `signature_image` varchar(550) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_password_changed` tinyint(1) NOT NULL DEFAULT 0,
  `is_status` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_histories`
--

CREATE TABLE `user_login_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `login_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ip_address` varchar(255) DEFAULT NULL,
  `mac_address` varchar(255) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `attep_type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_login_histories`
--

INSERT INTO `user_login_histories` (`id`, `user_id`, `login_at`, `ip_address`, `mac_address`, `device_name`, `attep_type`, `created_at`, `updated_at`) VALUES
(1454, 46, '2025-05-13 04:49:37', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1455, 46, '2025-05-14 05:14:22', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1456, 46, '2025-05-14 18:01:47', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1457, 46, '2025-05-15 06:46:57', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1458, 46, '2025-05-15 06:53:30', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1459, 46, '2025-05-15 06:55:35', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1460, 46, '2025-05-15 11:18:27', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1461, 46, '2025-05-15 13:33:52', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1462, 46, '2025-05-15 18:50:50', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1463, 46, '2025-05-16 08:32:23', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1464, 46, '2025-05-16 20:42:22', '103.213.242.110', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1465, 46, '2025-05-16 20:45:23', '103.213.242.110', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1466, 49, '2025-05-16 23:35:45', '103.143.183.250', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1467, 49, '2025-05-16 23:35:46', '103.143.183.250', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1468, 46, '2025-05-17 11:11:19', '2400:c600:3380:98b7:41e4:9133:ea93:2fd1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1469, 46, '2025-05-17 20:39:08', '103.213.242.110', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1470, 46, '2025-05-18 00:50:28', '103.213.242.110', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1471, 46, '2025-05-18 01:14:15', '103.213.242.110', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1472, 46, '2025-05-18 10:51:22', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1473, 49, '2025-05-18 10:51:28', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1474, 46, '2025-05-18 10:52:30', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1475, 49, '2025-05-18 10:54:13', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1476, 46, '2025-05-18 10:56:49', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1477, 49, '2025-05-18 10:57:46', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1478, 49, '2025-05-18 14:13:14', '103.124.183.137', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1479, 49, '2025-05-18 14:26:13', '103.124.183.142', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1480, 49, '2025-05-18 17:59:31', '103.124.183.137', '', 'Mozilla/5.0 (Linux; Android 10; vivo 1935) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/123.0.6312.118 Mobile Safari/537.36 VivoBrowser/14.0.4.0', 'Success', NULL, NULL),
(1481, 49, '2025-05-18 17:59:59', '103.124.183.137', '', 'Mozilla/5.0 (Linux; Android 10; vivo 1935) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/123.0.6312.118 Mobile Safari/537.36 VivoBrowser/14.0.4.0', 'Success', NULL, NULL),
(1482, 49, '2025-05-19 06:21:10', '103.166.59.141', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1483, 49, '2025-05-19 06:30:02', '103.166.59.139', '', 'Mozilla/5.0 (Linux; Android 10; vivo 1935; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/123.0.6312.118 Mobile Safari/537.36 VivoBrowser/14.0.4.0', 'Success', NULL, NULL),
(1484, 49, '2025-05-19 11:43:02', '103.166.59.142', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1485, 49, '2025-05-19 12:06:19', '103.166.59.141', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1486, 49, '2025-05-19 12:07:56', '103.166.59.138', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1487, 46, '2025-05-19 12:23:48', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1488, 49, '2025-05-19 12:46:53', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1489, 49, '2025-05-19 15:22:06', '103.166.59.141', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1490, 49, '2025-05-19 17:50:39', '202.86.216.98', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1491, 49, '2025-05-19 19:25:11', '36.255.82.255', '', 'Mozilla/5.0 (Linux; Android 10; vivo 1935; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/123.0.6312.118 Mobile Safari/537.36 VivoBrowser/14.0.4.0', 'Success', NULL, NULL),
(1492, 46, '2025-05-19 20:42:03', '103.213.242.110', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1493, 49, '2025-05-21 20:28:53', '202.86.219.64', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1494, 49, '2025-05-22 15:23:11', '103.166.59.117', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1495, 49, '2025-05-22 15:53:02', '103.166.59.112', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1496, 49, '2025-05-22 15:56:06', '103.114.36.229', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1497, 46, '2025-05-22 16:18:20', '103.213.242.110', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1498, 49, '2025-05-22 18:49:18', '202.86.216.158', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1499, 49, '2025-05-22 18:49:19', '202.86.216.158', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1500, 46, '2025-05-25 10:51:48', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1501, 49, '2025-05-26 12:44:16', '103.143.183.251', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1502, 46, '2025-05-26 12:46:59', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1503, 46, '2025-05-27 12:25:35', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1504, 46, '2025-05-27 15:09:39', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1505, 49, '2025-05-27 16:40:57', '175.29.198.90', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1506, 49, '2025-05-27 16:40:58', '175.29.198.90', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1507, 46, '2025-05-31 21:08:40', '103.114.36.229', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1508, 46, '2025-06-01 11:08:55', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'Success', NULL, NULL),
(1509, 46, '2025-06-01 15:41:45', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1510, 46, '2025-06-03 15:29:10', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1511, 46, '2025-06-03 15:29:12', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1512, 46, '2025-06-20 18:44:42', '103.114.36.229', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1513, 49, '2025-06-22 16:35:18', '2400:c600:358b:cbd:1:0:5d:165', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1514, 49, '2025-06-22 16:35:21', '2400:c600:358b:cbd:1:0:5d:165', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1515, 49, '2025-06-22 16:35:36', '2400:c600:358b:cbd:1:0:5d:165', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1516, 49, '2025-06-22 16:35:37', '2400:c600:358b:cbd:1:0:5d:165', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1517, 46, '2025-06-25 10:47:06', '103.148.99.67', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1518, 46, '2025-06-25 10:47:11', '103.148.99.67', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1519, 46, '2025-07-02 10:55:01', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1520, 46, '2025-07-03 16:53:16', '119.40.86.139', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'Success', NULL, NULL),
(1521, 46, '2025-07-08 16:18:25', '119.40.86.142', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'Success', NULL, NULL),
(1522, 49, '2025-07-09 20:06:59', '2400:c600:4724:3677:1:0:1b7a:54c8', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1523, 49, '2025-07-09 20:07:01', '2400:c600:4724:3677:1:0:1b7a:54c8', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1524, 49, '2025-07-09 20:09:45', '2400:c600:4724:3677:1:0:1b7a:54c8', '', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Mobile Safari/537.36', 'Success', NULL, NULL),
(1525, 46, '2025-07-12 12:49:23', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1526, 46, '2025-07-23 10:59:24', '175.29.198.90', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1527, 46, '2025-07-24 14:56:38', '119.40.86.139', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0', 'Success', NULL, NULL),
(1528, 2, '2025-07-30 08:32:02', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'Success', NULL, NULL),
(1529, 2, '2025-08-03 06:27:48', '::1', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'Success', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vat_rules`
--

CREATE TABLE `vat_rules` (
  `id` int(11) NOT NULL,
  `_name` varchar(200) DEFAULT NULL,
  `_rate` double(12,2) NOT NULL DEFAULT 0.00,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vat_rules`
--

INSERT INTO `vat_rules` (`id`, `_name`, `_rate`, `_status`, `updated_at`, `created_at`) VALUES
(2, NULL, 7.50, 1, NULL, '2022-09-19 13:20:13'),
(3, NULL, 15.00, 1, NULL, '2022-09-19 13:20:13'),
(4, NULL, 5.00, 1, NULL, '2022-09-19 13:20:13'),
(5, '2% Vat', 2.00, 1, '2022-09-27 23:03:07', '2022-09-19 13:20:13'),
(6, NULL, 12.00, 1, NULL, '2022-09-19 13:20:13'),
(7, 'Zero VAT', 0.00, 1, '2022-09-19 13:20:17', '2022-09-19 13:20:17'),
(8, '10% Vat', 10.00, 1, '2022-09-19 13:23:54', '2022-09-19 13:20:35'),
(9, '5% Vat', 5.00, 1, '2022-09-19 13:23:37', '2022-09-19 13:23:17');

-- --------------------------------------------------------

--
-- Table structure for table `vessel_infos`
--

CREATE TABLE `vessel_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_license_no` varchar(255) DEFAULT NULL,
  `_country_name` varchar(255) DEFAULT NULL,
  `_type` varchar(255) DEFAULT NULL COMMENT 'Local,foreign',
  `_route` varchar(255) DEFAULT NULL COMMENT 'Air,Sea,Road',
  `_owner_name` varchar(255) DEFAULT NULL,
  `_contact_one` varchar(255) DEFAULT NULL,
  `_contact_two` varchar(255) DEFAULT NULL,
  `_contact_three` varchar(255) DEFAULT NULL,
  `_capacity` double NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `is_delete` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vessel_routes`
--

CREATE TABLE `vessel_routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_loading_point` int(11) NOT NULL DEFAULT 0,
  `_loading_date_time` datetime DEFAULT NULL,
  `_unloading_point` int(11) NOT NULL DEFAULT 0,
  `_discharge_date_time` datetime DEFAULT NULL,
  `_arrival_date_time` datetime DEFAULT NULL,
  `_purchase_no` int(11) NOT NULL DEFAULT 0,
  `_route_note` text DEFAULT NULL,
  `_final_route` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vouchar_check_infos`
--

CREATE TABLE `vouchar_check_infos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_voucher_no` int(11) NOT NULL,
  `_bank_name` varchar(255) DEFAULT NULL,
  `_branch_name` varchar(255) DEFAULT NULL,
  `_check_no` varchar(255) NOT NULL,
  `_issue_date` date DEFAULT NULL,
  `_cash_date` date DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `_is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_bank_account` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_masters`
--

CREATE TABLE `voucher_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_code` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_time` varchar(60) NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_defalut_ledger_id` int(11) NOT NULL DEFAULT 0,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_voucher_type` varchar(20) DEFAULT NULL,
  `_transection_type` varchar(255) DEFAULT NULL,
  `_transection_ref` varchar(255) DEFAULT NULL,
  `_form_name` varchar(255) DEFAULT NULL,
  `_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_document` varchar(255) DEFAULT NULL,
  `_check_number` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_sales_man_id` int(11) NOT NULL DEFAULT 0,
  `_check_no` varchar(60) DEFAULT NULL,
  `_issue_date` date DEFAULT NULL,
  `_cash_date` date DEFAULT NULL,
  `_lc_no` varchar(200) DEFAULT NULL,
  `_lc_stage_id` int(11) NOT NULL DEFAULT 0,
  `_lc_id` int(11) NOT NULL DEFAULT 0,
  `_ref_table` varchar(255) DEFAULT NULL,
  `_ref_table_id` int(11) NOT NULL DEFAULT 0,
  `_month_no` int(11) NOT NULL DEFAULT 0,
  `_approved_status` tinyint(4) NOT NULL DEFAULT 0,
  `_approved_by` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_master_details`
--

CREATE TABLE `voucher_master_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` int(11) NOT NULL DEFAULT 0,
  `_account_group_id` int(11) NOT NULL DEFAULT 0,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 1,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL DEFAULT 0,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0,
  `_f_currency` varchar(50) DEFAULT NULL,
  `_foreign_amount` decimal(15,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_types`
--

CREATE TABLE `voucher_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voucher_types`
--

INSERT INTO `voucher_types` (`id`, `_name`, `_code`, `created_at`, `updated_at`) VALUES
(1, 'Journal Voucher', 'JV', NULL, NULL),
(2, 'Cash Payment', 'CP', NULL, NULL),
(3, 'Bank Receive', 'BR', NULL, NULL),
(4, 'Bank Payment', 'BP', NULL, NULL),
(5, 'Contra Voucher', 'CV', NULL, NULL),
(6, 'Cash Receive', 'CR', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `warranties`
--

CREATE TABLE `warranties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_name` varchar(255) NOT NULL,
  `_description` varchar(255) NOT NULL,
  `_duration` int(11) NOT NULL,
  `_period` varchar(255) NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warranties`
--

INSERT INTO `warranties` (`id`, `_name`, `_description`, `_duration`, `_period`, `_status`, `created_at`, `updated_at`) VALUES
(1, '1 Years', '1 Years', 1, 'years', 1, '2022-03-03 05:38:37', '2022-06-23 06:44:18'),
(3, '2 Years', '2 Years', 2, 'years', 1, '2022-06-23 10:41:32', '2022-06-23 10:41:32'),
(4, '6 Month', '6 Month', 6, 'months', 1, '2022-06-23 10:41:44', '2022-06-23 10:41:44'),
(5, '3 years', '3 years', 3, 'years', 1, '2022-06-23 10:41:59', '2022-06-23 10:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `warranty_accounts`
--

CREATE TABLE `warranty_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_account_type_id` bigint(20) UNSIGNED NOT NULL,
  `_account_group_id` bigint(20) UNSIGNED NOT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_dr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_cr_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_type` varchar(10) DEFAULT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_cost_center` int(11) NOT NULL,
  `_short_narr` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warranty_details`
--

CREATE TABLE `warranty_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` bigint(20) UNSIGNED NOT NULL,
  `_p_p_l_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `_qty` double(15,4) NOT NULL DEFAULT 0.0000,
  `_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_sales_rate` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_discount_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat` double(15,4) NOT NULL DEFAULT 0.0000,
  `_vat_amount` double(15,4) NOT NULL DEFAULT 0.0000,
  `_value` double(15,4) NOT NULL DEFAULT 0.0000,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_warranty` int(11) NOT NULL DEFAULT 0,
  `_warranty_reason` varchar(250) DEFAULT NULL,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_barcode` varchar(255) DEFAULT NULL,
  `_sales_no` int(11) NOT NULL DEFAULT 0,
  `_sales_detail_id` int(11) NOT NULL DEFAULT 0,
  `_manufacture_date` date DEFAULT NULL,
  `_expire_date` date DEFAULT NULL,
  `_no` bigint(20) UNSIGNED NOT NULL,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warranty_form_settings`
--

CREATE TABLE `warranty_form_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_default_warranty_charge` int(11) NOT NULL,
  `_inline_discount` int(11) NOT NULL,
  `_show_barcode` int(11) NOT NULL,
  `_show_vat` int(11) NOT NULL,
  `_show_unit` tinyint(4) NOT NULL DEFAULT 0,
  `_show_store` int(11) NOT NULL,
  `_show_self` int(11) NOT NULL,
  `_show_delivery_man` int(11) NOT NULL,
  `_show_sales_man` int(11) NOT NULL,
  `_show_cost_rate` int(11) NOT NULL,
  `_invoice_template` int(11) NOT NULL,
  `_show_warranty` int(11) NOT NULL,
  `_show_manufacture_date` int(11) NOT NULL,
  `_show_expire_date` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warranty_form_settings`
--

INSERT INTO `warranty_form_settings` (`id`, `_default_warranty_charge`, `_inline_discount`, `_show_barcode`, `_show_vat`, `_show_unit`, `_show_store`, `_show_self`, `_show_delivery_man`, `_show_sales_man`, `_show_cost_rate`, `_invoice_template`, `_show_warranty`, `_show_manufacture_date`, `_show_expire_date`, `created_at`, `updated_at`) VALUES
(1, 42, 1, 0, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, '2022-10-31 16:46:31', '2023-04-24 19:46:46');

-- --------------------------------------------------------

--
-- Table structure for table `warranty_masters`
--

CREATE TABLE `warranty_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_order_number` varchar(255) DEFAULT NULL,
  `_date` date NOT NULL,
  `_sales_date` date DEFAULT NULL,
  `_delivery_date` date DEFAULT NULL,
  `_time` varchar(60) NOT NULL,
  `_order_ref_id` int(11) NOT NULL DEFAULT 0,
  `_referance` varchar(255) DEFAULT NULL,
  `_address` varchar(255) DEFAULT NULL,
  `_phone` varchar(255) DEFAULT NULL,
  `_ledger_id` bigint(20) UNSIGNED NOT NULL,
  `_user_id` bigint(20) UNSIGNED NOT NULL,
  `_user_name` varchar(255) DEFAULT NULL,
  `_note` varchar(255) DEFAULT NULL,
  `_total` double(15,4) NOT NULL DEFAULT 0.0000,
  `_branch_id` bigint(20) UNSIGNED NOT NULL,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `_store_salves_id` varchar(255) DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_lock` tinyint(4) NOT NULL DEFAULT 0,
  `_waranty_status` tinyint(4) NOT NULL DEFAULT 0,
  `_apporoved_by` int(11) NOT NULL DEFAULT 0,
  `_created_by` varchar(60) DEFAULT NULL,
  `_updated_by` varchar(60) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `_budget_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warrenty_dates`
--

CREATE TABLE `warrenty_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_item_id` int(11) NOT NULL DEFAULT 0,
  `_p_p_l_id` int(11) NOT NULL DEFAULT 0,
  `_master_id` int(11) NOT NULL DEFAULT 0,
  `_detail_id` int(11) NOT NULL DEFAULT 0,
  `_trans_type` varchar(255) DEFAULT NULL,
  `_start_date` date DEFAULT NULL,
  `_end_date` date DEFAULT NULL,
  `_created_by` int(11) NOT NULL DEFAULT 0,
  `_updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workorders`
--

CREATE TABLE `workorders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `wo_no` varchar(255) NOT NULL,
  `notesheet_no` varchar(255) NOT NULL,
  `notesheet_id` int(11) NOT NULL DEFAULT 0,
  `rlp_no` varchar(255) NOT NULL,
  `rlp_id` int(11) NOT NULL DEFAULT 0,
  `item` int(11) NOT NULL DEFAULT 0,
  `item_name` varchar(255) NOT NULL,
  `unit` int(11) NOT NULL DEFAULT 0,
  `part_no` varchar(255) DEFAULT NULL,
  `quantity` double NOT NULL DEFAULT 0,
  `unit_price` double NOT NULL DEFAULT 0,
  `total` double NOT NULL DEFAULT 0,
  `remarks` longtext DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `_status` int(11) NOT NULL DEFAULT 0,
  `_lock` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workorders_master`
--

CREATE TABLE `workorders_master` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `_date` date NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `notesheet_prefix` varchar(255) NOT NULL,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_cost_center_id` int(11) NOT NULL DEFAULT 0,
  `request_project` int(11) NOT NULL DEFAULT 0,
  `request_warehouse` int(11) NOT NULL DEFAULT 0,
  `_store_id` int(11) NOT NULL DEFAULT 0,
  `wo_no` varchar(255) DEFAULT NULL,
  `rlp_id` int(11) NOT NULL DEFAULT 0,
  `rlp_no` varchar(255) DEFAULT NULL,
  `notesheet_id` int(11) NOT NULL DEFAULT 0,
  `notesheet_no` varchar(255) DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `wo_info` longtext DEFAULT NULL,
  `supplier_id` int(11) NOT NULL DEFAULT 0,
  `supplier_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `concern_person` varchar(255) DEFAULT NULL,
  `cell_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_of_item` double NOT NULL DEFAULT 0,
  `sub_total` double NOT NULL DEFAULT 0,
  `ait_input` double NOT NULL DEFAULT 0,
  `total_ait` double NOT NULL DEFAULT 0,
  `vat_input` double NOT NULL DEFAULT 0,
  `total_vat` double NOT NULL DEFAULT 0,
  `_discount_input` double NOT NULL DEFAULT 0,
  `total_discount` double NOT NULL DEFAULT 0,
  `total_afterdiscount` double NOT NULL DEFAULT 0,
  `grand_total` double NOT NULL DEFAULT 0,
  `remarks` longtext DEFAULT NULL,
  `terms_condition` longtext DEFAULT NULL,
  `notesheet_status` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `is_wo` tinyint(4) NOT NULL DEFAULT 0,
  `attached_file` varchar(255) DEFAULT NULL,
  `is_viewed` tinyint(4) NOT NULL DEFAULT 0,
  `is_ns` tinyint(4) NOT NULL DEFAULT 0,
  `_status` int(11) NOT NULL DEFAULT 0,
  `_lock` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `is_delete` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` int(11) NOT NULL DEFAULT 0,
  `_branch_id` int(11) NOT NULL DEFAULT 0,
  `_name` varchar(255) DEFAULT NULL,
  `_detail` text DEFAULT NULL,
  `_status` tinyint(4) NOT NULL DEFAULT 0,
  `_user_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `organization_id`, `_branch_id`, `_name`, `_detail`, `_status`, `_user_id`, `created_at`, `updated_at`) VALUES
(3, 0, 0, 'Jessore', NULL, 1, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `_account_head` (`_account_head`),
  ADD KEY `_account_group` (`_account_group`),
  ADD KEY `_account_ledger` (`_account_ledger`),
  ADD KEY `_branch_id` (`_branch_id`),
  ADD KEY `_cost_center` (`_cost_center`);

--
-- Indexes for table `account_details`
--
ALTER TABLE `account_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`(191)),
  ADD KEY `ad_name` (`ad_name`);

--
-- Indexes for table `account_groups`
--
ALTER TABLE `account_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_groups__account_head_id_foreign` (`_account_head_id`);

--
-- Indexes for table `account_group_configs`
--
ALTER TABLE `account_group_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_heads`
--
ALTER TABLE `account_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `account_ledgers`
--
ALTER TABLE `account_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_ledgers__account_group_id_foreign` (`_account_group_id`);

--
-- Indexes for table `assets_conditions`
--
ALTER TABLE `assets_conditions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_device_locations`
--
ALTER TABLE `assets_device_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assets_locations`
--
ALTER TABLE `assets_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_assigns`
--
ALTER TABLE `asset_assigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_depreciations`
--
ALTER TABLE `asset_depreciations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_depreciation_details`
--
ALTER TABLE `asset_depreciation_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_eng_consumptions`
--
ALTER TABLE `asset_eng_consumptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_images`
--
ALTER TABLE `asset_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_import_costs`
--
ALTER TABLE `asset_import_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_import_cost_details`
--
ALTER TABLE `asset_import_cost_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_inspections`
--
ALTER TABLE `asset_inspections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_items`
--
ALTER TABLE `asset_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_maintainces`
--
ALTER TABLE `asset_maintainces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_sales`
--
ALTER TABLE `asset_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_leaves`
--
ALTER TABLE `assign_leaves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_statuses`
--
ALTER TABLE `assign_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audits_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audits_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Indexes for table `bank_check_infos`
--
ALTER TABLE `bank_check_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barcode_details`
--
ALTER TABLE `barcode_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bonus_item_details`
--
ALTER TABLE `bonus_item_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_details`
--
ALTER TABLE `budget_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_item_details`
--
ALTER TABLE `budget_item_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_revisions`
--
ALTER TABLE `budget_revisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_revision_details`
--
ALTER TABLE `budget_revision_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_revision_item_details`
--
ALTER TABLE `budget_revision_item_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cat_wise_ta_bills`
--
ALTER TABLE `cat_wise_ta_bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cost_centers`
--
ALTER TABLE `cost_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cost_center_authorised_chains`
--
ALTER TABLE `cost_center_authorised_chains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_salary_masters`
--
ALTER TABLE `current_salary_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `current_salary_structures`
--
ALTER TABLE `current_salary_structures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cylindars`
--
ALTER TABLE `cylindars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cylindar_location_histories`
--
ALTER TABLE `cylindar_location_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cylinder_product_price_lists`
--
ALTER TABLE `cylinder_product_price_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_adjustments`
--
ALTER TABLE `damage_adjustments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_adjustments__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `damage_adjustments__user_id_foreign` (`_user_id`),
  ADD KEY `damage_adjustments__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `damage_adjustment_details`
--
ALTER TABLE `damage_adjustment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_adjustment_details__item_id_foreign` (`_item_id`),
  ADD KEY `damage_adjustment_details__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `damage_adjustment_details__no_foreign` (`_no`),
  ADD KEY `damage_adjustment_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `damage_barcodes`
--
ALTER TABLE `damage_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_form_settings`
--
ALTER TABLE `damage_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_from_stocks`
--
ALTER TABLE `damage_from_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_from_stocks__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `damage_from_stocks__user_id_foreign` (`_user_id`),
  ADD KEY `damage_from_stocks__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `damage_from_stock_barcodes`
--
ALTER TABLE `damage_from_stock_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_from_stock_details`
--
ALTER TABLE `damage_from_stock_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_from_stock_details__item_id_foreign` (`_item_id`),
  ADD KEY `damage_from_stock_details__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `damage_from_stock_details__no_foreign` (`_no`),
  ADD KEY `damage_from_stock_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `damage_item_histories`
--
ALTER TABLE `damage_item_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_item_histories__item_id_foreign` (`_item_id`),
  ADD KEY `damage_item_histories__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `damage_receive_accounts`
--
ALTER TABLE `damage_receive_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_receive_accounts__no_foreign` (`_no`),
  ADD KEY `damage_receive_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `damage_receive_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `damage_receive_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `damage_receive_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `damage_receive_barcodes`
--
ALTER TABLE `damage_receive_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_receive_details`
--
ALTER TABLE `damage_receive_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_receive_details__item_id_foreign` (`_item_id`),
  ADD KEY `damage_receive_details__no_foreign` (`_no`),
  ADD KEY `damage_receive_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `damage_receive_form_settings`
--
ALTER TABLE `damage_receive_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_receive_masters`
--
ALTER TABLE `damage_receive_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_receive_masters__branch_id_foreign` (`_branch_id`),
  ADD KEY `damage_receive_masters__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `damage_receive_masters__user_id_foreign` (`_user_id`);

--
-- Indexes for table `damage_send_accounts`
--
ALTER TABLE `damage_send_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_send_accounts__no_foreign` (`_no`),
  ADD KEY `damage_send_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `damage_send_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `damage_send_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `damage_send_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `damage_send_barcodes`
--
ALTER TABLE `damage_send_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_send_details`
--
ALTER TABLE `damage_send_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_send_details__item_id_foreign` (`_item_id`),
  ADD KEY `damage_send_details__no_foreign` (`_no`),
  ADD KEY `damage_send_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `damage_send_form_settings`
--
ALTER TABLE `damage_send_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_send_masters`
--
ALTER TABLE `damage_send_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_send_masters__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `damage_send_masters__user_id_foreign` (`_user_id`),
  ADD KEY `damage_send_masters__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `default_ledgers`
--
ALTER TABLE `default_ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direct_manufature_row_goods`
--
ALTER TABLE `direct_manufature_row_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kitchen_row_goods__item_id_foreign` (`_item_id`),
  ADD KEY `kitchen_row_goods__no_foreign` (`_no`),
  ADD KEY `kitchen_row_goods__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `direct_productions`
--
ALTER TABLE `direct_productions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direct_production_barcodes`
--
ALTER TABLE `direct_production_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direct_production_finis_goods`
--
ALTER TABLE `direct_production_finis_goods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_duties`
--
ALTER TABLE `employee_duties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `free_item_setups`
--
ALTER TABLE `free_item_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `honorarium_bills`
--
ALTER TABLE `honorarium_bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `honorarium_bill_details`
--
ALTER TABLE `honorarium_bill_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `honorarium_payments`
--
ALTER TABLE `honorarium_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `honorarium_payment_details`
--
ALTER TABLE `honorarium_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `honorim_setups`
--
ALTER TABLE `honorim_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_attendances`
--
ALTER TABLE `hrm_attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_departments`
--
ALTER TABLE `hrm_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_education`
--
ALTER TABLE `hrm_education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_emergencies`
--
ALTER TABLE `hrm_emergencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_empaddresses`
--
ALTER TABLE `hrm_empaddresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_employees`
--
ALTER TABLE `hrm_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_emp_categories`
--
ALTER TABLE `hrm_emp_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_emp_locations`
--
ALTER TABLE `hrm_emp_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_experiences`
--
ALTER TABLE `hrm_experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_grades`
--
ALTER TABLE `hrm_grades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_guarantors`
--
ALTER TABLE `hrm_guarantors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_holidays`
--
ALTER TABLE `hrm_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_holiday_details`
--
ALTER TABLE `hrm_holiday_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_itaxconfigs`
--
ALTER TABLE `hrm_itaxconfigs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_itaxledgers`
--
ALTER TABLE `hrm_itaxledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_itaxpayables`
--
ALTER TABLE `hrm_itaxpayables`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_itaxrebates`
--
ALTER TABLE `hrm_itaxrebates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_jobcontracts`
--
ALTER TABLE `hrm_jobcontracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_jobs`
--
ALTER TABLE `hrm_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_jobtitles`
--
ALTER TABLE `hrm_jobtitles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_languages`
--
ALTER TABLE `hrm_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_leavebalances`
--
ALTER TABLE `hrm_leavebalances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_leaveentitlements`
--
ALTER TABLE `hrm_leaveentitlements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_leavetypes`
--
ALTER TABLE `hrm_leavetypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_monthly_salary_details`
--
ALTER TABLE `hrm_monthly_salary_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_monthly_salary_masters`
--
ALTER TABLE `hrm_monthly_salary_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_nominees`
--
ALTER TABLE `hrm_nominees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_payheads`
--
ALTER TABLE `hrm_payheads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_payinfos`
--
ALTER TABLE `hrm_payinfos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_payunits`
--
ALTER TABLE `hrm_payunits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_pay_head_types`
--
ALTER TABLE `hrm_pay_head_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_profitcenters`
--
ALTER TABLE `hrm_profitcenters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_recruitments`
--
ALTER TABLE `hrm_recruitments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_rewards`
--
ALTER TABLE `hrm_rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_salarystructures`
--
ALTER TABLE `hrm_salarystructures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_sstructuredetails`
--
ALTER TABLE `hrm_sstructuredetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_trainings`
--
ALTER TABLE `hrm_trainings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_transfers`
--
ALTER TABLE `hrm_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_vacancies`
--
ALTER TABLE `hrm_vacancies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hrm_weekworkdays`
--
ALTER TABLE `hrm_weekworkdays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_cost_accounts`
--
ALTER TABLE `import_cost_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `import_cost_accounts__no_foreign` (`_no`),
  ADD KEY `import_cost_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `import_cost_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `import_cost_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `import_cost_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `import_cost_ledgers`
--
ALTER TABLE `import_cost_ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_puchases`
--
ALTER TABLE `import_puchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `import_puchases__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `import_puchases__user_id_foreign` (`_user_id`),
  ADD KEY `import_puchases__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `import_puchase_accounts`
--
ALTER TABLE `import_puchase_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `import_puchase_accounts__no_foreign` (`_no`),
  ADD KEY `import_puchase_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `import_puchase_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `import_puchase_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `import_puchase_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `import_puchase_barcodes`
--
ALTER TABLE `import_puchase_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_puchase_details`
--
ALTER TABLE `import_puchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `import_puchase_details__item_id_foreign` (`_item_id`),
  ADD KEY `import_puchase_details__no_foreign` (`_no`),
  ADD KEY `import_puchase_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `import_puchase_form_settings`
--
ALTER TABLE `import_puchase_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `import_receive_vessel_infos`
--
ALTER TABLE `import_receive_vessel_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incentive_earn_ledger_details`
--
ALTER TABLE `incentive_earn_ledger_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incentive_earn_masters`
--
ALTER TABLE `incentive_earn_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `individual_replace_form_settings`
--
ALTER TABLE `individual_replace_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `individual_replace_in_accounts`
--
ALTER TABLE `individual_replace_in_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `individual_replace_in_accounts__no_foreign` (`_no`),
  ADD KEY `individual_replace_in_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `individual_replace_in_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `individual_replace_in_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `individual_replace_in_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `individual_replace_in_items`
--
ALTER TABLE `individual_replace_in_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `individual_replace_in_items__item_id_foreign` (`_item_id`),
  ADD KEY `individual_replace_in_items__no_foreign` (`_no`),
  ADD KEY `individual_replace_in_items__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `individual_replace_masters`
--
ALTER TABLE `individual_replace_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `individual_replace_masters__customer_id_foreign` (`_customer_id`),
  ADD KEY `individual_replace_masters__supplier_id_foreign` (`_supplier_id`),
  ADD KEY `individual_replace_masters__user_id_foreign` (`_user_id`),
  ADD KEY `individual_replace_masters__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `individual_replace_old_items`
--
ALTER TABLE `individual_replace_old_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `individual_replace_old_items__item_id_foreign` (`_item_id`),
  ADD KEY `individual_replace_old_items__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `individual_replace_old_items__no_foreign` (`_no`),
  ADD KEY `individual_replace_old_items__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `individual_replace_out_accounts`
--
ALTER TABLE `individual_replace_out_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `individual_replace_out_accounts__no_foreign` (`_no`),
  ADD KEY `individual_replace_out_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `individual_replace_out_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `individual_replace_out_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `individual_replace_out_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `individual_replace_out_items`
--
ALTER TABLE `individual_replace_out_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `individual_replace_out_items__item_id_foreign` (`_item_id`),
  ADD KEY `individual_replace_out_items__no_foreign` (`_no`),
  ADD KEY `individual_replace_out_items__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `inspection_check_categories`
--
ALTER TABLE `inspection_check_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inspection_check_lists`
--
ALTER TABLE `inspection_check_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventories__category_id_foreign` (`_category_id`),
  ADD KEY `_item` (`_item`),
  ADD KEY `_barcode` (`_barcode`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_prefixes`
--
ALTER TABLE `invoice_prefixes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_balance_without_lots`
--
ALTER TABLE `item_balance_without_lots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_bonus_setups`
--
ALTER TABLE `item_bonus_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_brands`
--
ALTER TABLE `item_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_inventories`
--
ALTER TABLE `item_inventories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_inventories__item_id_foreign` (`_item_id`),
  ADD KEY `item_inventories__branch_id_foreign` (`_branch_id`),
  ADD KEY `_category_id` (`_category_id`),
  ADD KEY `_date` (`_date`),
  ADD KEY `_store_id` (`_store_id`),
  ADD KEY `_cost_center_id` (`_cost_center_id`);

--
-- Indexes for table `item_pack_sizes`
--
ALTER TABLE `item_pack_sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_rate_histories`
--
ALTER TABLE `item_rate_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_rate_history_logs`
--
ALTER TABLE `item_rate_history_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_types`
--
ALTER TABLE `item_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kitchens`
--
ALTER TABLE `kitchens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kitchen_finish_goods`
--
ALTER TABLE `kitchen_finish_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kitchen_finish_goods__item_id_foreign` (`_item_id`),
  ADD KEY `kitchen_finish_goods__no_foreign` (`_no`),
  ADD KEY `kitchen_finish_goods__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `kitchen_row_goods`
--
ALTER TABLE `kitchen_row_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kitchen_row_goods__item_id_foreign` (`_item_id`),
  ADD KEY `kitchen_row_goods__no_foreign` (`_no`),
  ADD KEY `kitchen_row_goods__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language_meta`
--
ALTER TABLE `language_meta`
  ADD PRIMARY KEY (`lang_meta_id`);

--
-- Indexes for table `lc_amendments`
--
ALTER TABLE `lc_amendments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lc_amendments_amendment_no_unique` (`amendment_no`),
  ADD KEY `lc_amendments_lc_master_id_foreign` (`lc_master_id`);

--
-- Indexes for table `lc_amendment_types`
--
ALTER TABLE `lc_amendment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lc_items`
--
ALTER TABLE `lc_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lc_items_lc_master_id_foreign` (`lc_master_id`);

--
-- Indexes for table `lc_item_costs`
--
ALTER TABLE `lc_item_costs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lc_item_costs_lc_master_id_foreign` (`lc_master_id`);

--
-- Indexes for table `lc_masters`
--
ALTER TABLE `lc_masters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lc_masters_lc_ip_no_unique` (`lc_ip_no`),
  ADD UNIQUE KEY `lc_masters_pi_no_unique` (`pi_no`);

--
-- Indexes for table `main_account_head`
--
ALTER TABLE `main_account_head`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_issues`
--
ALTER TABLE `material_issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_issues__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `material_issues__user_id_foreign` (`_user_id`),
  ADD KEY `material_issues__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `material_issue_barcodes`
--
ALTER TABLE `material_issue_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_issue_details`
--
ALTER TABLE `material_issue_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_issue_details__item_id_foreign` (`_item_id`),
  ADD KEY `material_issue_details__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `material_issue_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `material_issue_returns`
--
ALTER TABLE `material_issue_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_issue_returns__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `material_issue_returns__user_id_foreign` (`_user_id`),
  ADD KEY `material_issue_returns__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `material_issue_return_barcodes`
--
ALTER TABLE `material_issue_return_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_issue_return_details`
--
ALTER TABLE `material_issue_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `material_issue_return_details__item_id_foreign` (`_item_id`),
  ADD KEY `material_issue_return_details__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `material_issue_return_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `material_issue_return_settings`
--
ALTER TABLE `material_issue_return_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_issue_settings`
--
ALTER TABLE `material_issue_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `monthly_sales_targets`
--
ALTER TABLE `monthly_sales_targets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mother_vessels`
--
ALTER TABLE `mother_vessels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `musak_four_point_threes`
--
ALTER TABLE `musak_four_point_threes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `musak_four_point_three_additions`
--
ALTER TABLE `musak_four_point_three_additions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `musak_four_point_three_additions__no_foreign` (`_no`),
  ADD KEY `musak_four_point_three_additions__ledger_id_foreign` (`_ledger_id`);

--
-- Indexes for table `musak_four_point_three_inputs`
--
ALTER TABLE `musak_four_point_three_inputs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `musak_four_point_three_inputs__no_foreign` (`_no`),
  ADD KEY `musak_four_point_three_inputs__item_id_foreign` (`_item_id`);

--
-- Indexes for table `notesheets`
--
ALTER TABLE `notesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notesheets_master`
--
ALTER TABLE `notesheets_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notesheet_account_details`
--
ALTER TABLE `notesheet_account_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notesheet_remarks_history`
--
ALTER TABLE `notesheet_remarks_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_branches`
--
ALTER TABLE `organization_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_branch_stores`
--
ALTER TABLE `organization_branch_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_cost_centers`
--
ALTER TABLE `organization_cost_centers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_departments`
--
ALTER TABLE `organization_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_department_designations`
--
ALTER TABLE `organization_department_designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_designations`
--
ALTER TABLE `organization_designations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_stores`
--
ALTER TABLE `organization_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `org_branch_items`
--
ALTER TABLE `org_branch_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_rows`
--
ALTER TABLE `page_rows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_receive_details`
--
ALTER TABLE `payment_receive_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_receive_masters`
--
ALTER TABLE `payment_receive_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_receive_masters__user_id_foreign` (`_user_id`),
  ADD KEY `payment_receive_masters__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postcodes`
--
ALTER TABLE `postcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productions`
--
ALTER TABLE `productions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_from_settings`
--
ALTER TABLE `production_from_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_partial_receives`
--
ALTER TABLE `production_partial_receives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_status`
--
ALTER TABLE `production_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_incentive_earns`
--
ALTER TABLE `product_incentive_earns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_price_lists`
--
ALTER TABLE `product_price_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `proforma_sales`
--
ALTER TABLE `proforma_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proforma_sales__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `proforma_sales__user_id_foreign` (`_user_id`),
  ADD KEY `proforma_sales__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `proforma_sales_details`
--
ALTER TABLE `proforma_sales_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proforma_sales_details__item_id_foreign` (`_item_id`),
  ADD KEY `proforma_sales_details__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `proforma_sales_details__no_foreign` (`_no`),
  ADD KEY `proforma_sales_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `project_management`
--
ALTER TABLE `project_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `purchases__user_id_foreign` (`_user_id`),
  ADD KEY `purchases__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `purchase_accounts`
--
ALTER TABLE `purchase_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_accounts__no_foreign` (`_no`),
  ADD KEY `purchase_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `purchase_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `purchase_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `purchase_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `purchase_barcodes`
--
ALTER TABLE `purchase_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details__item_id_foreign` (`_item_id`),
  ADD KEY `purchase_details__no_foreign` (`_no`),
  ADD KEY `purchase_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `purchase_form_settings`
--
ALTER TABLE `purchase_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_orders__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `purchase_orders__user_id_foreign` (`_user_id`),
  ADD KEY `purchase_orders__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `purchase_order_accounts`
--
ALTER TABLE `purchase_order_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_accounts__no_foreign` (`_no`),
  ADD KEY `purchase_order_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `purchase_order_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `purchase_order_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `purchase_order_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_order_details__item_id_foreign` (`_item_id`),
  ADD KEY `purchase_order_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_returns__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `purchase_returns__user_id_foreign` (`_user_id`),
  ADD KEY `purchase_returns__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `purchase_return_accounts`
--
ALTER TABLE `purchase_return_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_accounts__no_foreign` (`_no`),
  ADD KEY `purchase_return_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `purchase_return_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `purchase_return_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `purchase_return_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `purchase_return_barcodes`
--
ALTER TABLE `purchase_return_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_details__item_id_foreign` (`_item_id`),
  ADD KEY `purchase_return_details__no_foreign` (`_no`),
  ADD KEY `purchase_return_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `purchase_return_form_settings`
--
ALTER TABLE `purchase_return_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quaterly_individual_insentives`
--
ALTER TABLE `quaterly_individual_insentives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quaterly_insentive_setups`
--
ALTER TABLE `quaterly_insentive_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receive_payments`
--
ALTER TABLE `receive_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receive_payment_details`
--
ALTER TABLE `receive_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replacement_form_settings`
--
ALTER TABLE `replacement_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replacement_item_accounts`
--
ALTER TABLE `replacement_item_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replacement_item_accounts__no_foreign` (`_no`),
  ADD KEY `replacement_item_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `replacement_item_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `replacement_item_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `replacement_item_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `replacement_item_ins`
--
ALTER TABLE `replacement_item_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replacement_item_ins__item_id_foreign` (`_item_id`),
  ADD KEY `replacement_item_ins__no_foreign` (`_no`),
  ADD KEY `replacement_item_ins__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `replacement_item_outs`
--
ALTER TABLE `replacement_item_outs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replacement_item_outs__item_id_foreign` (`_item_id`),
  ADD KEY `replacement_item_outs__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `replacement_item_outs__no_foreign` (`_no`),
  ADD KEY `replacement_item_outs__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `replacement_masters`
--
ALTER TABLE `replacement_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `replacement_masters__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `replacement_masters__user_id_foreign` (`_user_id`),
  ADD KEY `replacement_masters__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `rep_in_barcodes`
--
ALTER TABLE `rep_in_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rep_out_barcodes`
--
ALTER TABLE `rep_out_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `restaurant_category_settings`
--
ALTER TABLE `restaurant_category_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resturant_details`
--
ALTER TABLE `resturant_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resturant_details__item_id_foreign` (`_item_id`),
  ADD KEY `resturant_details__no_foreign` (`_no`),
  ADD KEY `resturant_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `resturant_form_settings`
--
ALTER TABLE `resturant_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resturant_sales`
--
ALTER TABLE `resturant_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resturant_sales__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `resturant_sales__user_id_foreign` (`_user_id`),
  ADD KEY `resturant_sales__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `resturant_sales_accounts`
--
ALTER TABLE `resturant_sales_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resturant_sales_accounts__no_foreign` (`_no`),
  ADD KEY `resturant_sales_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `resturant_sales_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `resturant_sales_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `resturant_sales_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `rlp_access_chains`
--
ALTER TABLE `rlp_access_chains`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rlp_access_chain_users`
--
ALTER TABLE `rlp_access_chain_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rlp_account_details`
--
ALTER TABLE `rlp_account_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rlp_acknowledgements`
--
ALTER TABLE `rlp_acknowledgements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rlp_delete_histories`
--
ALTER TABLE `rlp_delete_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rlp_details`
--
ALTER TABLE `rlp_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rlp_masters`
--
ALTER TABLE `rlp_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rlp_remarks`
--
ALTER TABLE `rlp_remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rlp_user_groups`
--
ALTER TABLE `rlp_user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `saif_employee_db`
--
ALTER TABLE `saif_employee_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_sheets`
--
ALTER TABLE `salary_sheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `sales__user_id_foreign` (`_user_id`),
  ADD KEY `sales__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_accounts`
--
ALTER TABLE `sales_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_accounts__no_foreign` (`_no`),
  ADD KEY `sales_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `sales_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `sales_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `sales_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_barcodes`
--
ALTER TABLE `sales_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_commision_plans`
--
ALTER TABLE `sales_commision_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_commision_plan_details`
--
ALTER TABLE `sales_commision_plan_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_details`
--
ALTER TABLE `sales_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_details__item_id_foreign` (`_item_id`),
  ADD KEY `sales_details__no_foreign` (`_no`),
  ADD KEY `sales_details__branch_id_foreign` (`_branch_id`),
  ADD KEY `sales_details__p_p_l_id_foreign` (`_p_p_l_id`);

--
-- Indexes for table `sales_form_settings`
--
ALTER TABLE `sales_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_orders__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `sales_orders__user_id_foreign` (`_user_id`),
  ADD KEY `sales_orders__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_order_details`
--
ALTER TABLE `sales_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_order_details__item_id_foreign` (`_item_id`),
  ADD KEY `sales_order_details__no_foreign` (`_no`),
  ADD KEY `sales_order_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_returns__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `sales_returns__user_id_foreign` (`_user_id`),
  ADD KEY `sales_returns__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_return_accounts`
--
ALTER TABLE `sales_return_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_return_accounts__no_foreign` (`_no`),
  ADD KEY `sales_return_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `sales_return_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `sales_return_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `sales_return_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_return_barcodes`
--
ALTER TABLE `sales_return_barcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_details`
--
ALTER TABLE `sales_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_return_details__item_id_foreign` (`_item_id`),
  ADD KEY `sales_return_details__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `sales_return_details__no_foreign` (`_no`),
  ADD KEY `sales_return_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_return_form_settings`
--
ALTER TABLE `sales_return_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_return_wlms`
--
ALTER TABLE `sales_return_wlms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_return_wlms__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `sales_return_wlms__user_id_foreign` (`_user_id`),
  ADD KEY `sales_return_wlms__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_return_wlm_accounts`
--
ALTER TABLE `sales_return_wlm_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_return_wlm_accounts__no_foreign` (`_no`),
  ADD KEY `sales_return_wlm_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `sales_return_wlm_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `sales_return_wlm_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `sales_return_wlm_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_return_wlm_details`
--
ALTER TABLE `sales_return_wlm_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_return_wlm_details__item_id_foreign` (`_item_id`),
  ADD KEY `sales_return_wlm_details__no_foreign` (`_no`),
  ADD KEY `sales_return_wlm_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_without_lots`
--
ALTER TABLE `sales_without_lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_without_lots__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `sales_without_lots__user_id_foreign` (`_user_id`),
  ADD KEY `sales_without_lots__branch_id_foreign` (`_branch_id`),
  ADD KEY `_order_number` (`_order_number`),
  ADD KEY `BillNo` (`BillNo`);

--
-- Indexes for table `sales_without_lot_accounts`
--
ALTER TABLE `sales_without_lot_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_without_lot_accounts__no_foreign` (`_no`),
  ADD KEY `sales_without_lot_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `sales_without_lot_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `sales_without_lot_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `sales_without_lot_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sales_without_lot_details`
--
ALTER TABLE `sales_without_lot_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_without_lot_details__item_id_foreign` (`_item_id`),
  ADD KEY `sales_without_lot_details__no_foreign` (`_no`),
  ADD KEY `sales_without_lot_details__branch_id_foreign` (`_branch_id`),
  ADD KEY `_order_number` (`_order_number`);

--
-- Indexes for table `security_deposits`
--
ALTER TABLE `security_deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_deposits__user_id_foreign` (`_user_id`);

--
-- Indexes for table `service_accounts`
--
ALTER TABLE `service_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_accounts__no_foreign` (`_no`),
  ADD KEY `service_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `service_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `service_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `service_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `service_details`
--
ALTER TABLE `service_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_details__item_id_foreign` (`_item_id`),
  ADD KEY `service_details__no_foreign` (`_no`),
  ADD KEY `service_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `service_from_settings`
--
ALTER TABLE `service_from_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_masters`
--
ALTER TABLE `service_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_masters__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `service_masters__user_id_foreign` (`_user_id`),
  ADD KEY `service_masters__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `setting_key_values`
--
ALTER TABLE `setting_key_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_media`
--
ALTER TABLE `social_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sold_item_stock`
--
ALTER TABLE `sold_item_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_details`
--
ALTER TABLE `status_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `steward_allocations`
--
ALTER TABLE `steward_allocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_bill_collections`
--
ALTER TABLE `stm_bill_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_bill_masters`
--
ALTER TABLE `stm_bill_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_bill_master_details`
--
ALTER TABLE `stm_bill_master_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_classes`
--
ALTER TABLE `stm_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_collection_masters`
--
ALTER TABLE `stm_collection_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_collection_master_details`
--
ALTER TABLE `stm_collection_master_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_divisions`
--
ALTER TABLE `stm_divisions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_division_class_students`
--
ALTER TABLE `stm_division_class_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_education_sessions`
--
ALTER TABLE `stm_education_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_income_ledger_setups`
--
ALTER TABLE `stm_income_ledger_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_students`
--
ALTER TABLE `stm_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stm_subjects`
--
ALTER TABLE `stm_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_ins`
--
ALTER TABLE `stock_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_ins__item_id_foreign` (`_item_id`),
  ADD KEY `stock_ins__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `stock_ins__no_foreign` (`_no`),
  ADD KEY `stock_ins__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `stock_outs`
--
ALTER TABLE `stock_outs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_outs__item_id_foreign` (`_item_id`),
  ADD KEY `stock_outs__p_p_l_id_foreign` (`_p_p_l_id`),
  ADD KEY `stock_outs__no_foreign` (`_no`),
  ADD KEY `stock_outs__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `store_houses`
--
ALTER TABLE `store_houses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_house_selves`
--
ALTER TABLE `store_house_selves`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_class_subjects`
--
ALTER TABLE `student_class_subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_payment_details`
--
ALTER TABLE `supplier_payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sys_customform`
--
ALTER TABLE `sys_customform`
  ADD PRIMARY KEY (`_id`);

--
-- Indexes for table `sys_customformfields`
--
ALTER TABLE `sys_customformfields`
  ADD PRIMARY KEY (`_id`),
  ADD UNIQUE KEY `_tableid_field` (`_tableid`,`_field`),
  ADD KEY `_tableid` (`_tableid`);

--
-- Indexes for table `table_infos`
--
ALTER TABLE `table_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ta_da_setups`
--
ALTER TABLE `ta_da_setups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cus_categories`
--
ALTER TABLE `tbl_cus_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tranport_types`
--
ALTER TABLE `tranport_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transection_terms`
--
ALTER TABLE `transection_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_conversions`
--
ALTER TABLE `unit_conversions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upazilas`
--
ALTER TABLE `upazilas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_login_histories`
--
ALTER TABLE `user_login_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vat_rules`
--
ALTER TABLE `vat_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vessel_infos`
--
ALTER TABLE `vessel_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vessel_routes`
--
ALTER TABLE `vessel_routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchar_check_infos`
--
ALTER TABLE `vouchar_check_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_masters`
--
ALTER TABLE `voucher_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voucher_masters__user_id_foreign` (`_user_id`),
  ADD KEY `voucher_masters__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `voucher_master_details`
--
ALTER TABLE `voucher_master_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voucher_master_details__no_foreign` (`_no`),
  ADD KEY `voucher_master_details__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `voucher_master_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `voucher_types`
--
ALTER TABLE `voucher_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warranties`
--
ALTER TABLE `warranties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warranty_accounts`
--
ALTER TABLE `warranty_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warranty_accounts__no_foreign` (`_no`),
  ADD KEY `warranty_accounts__account_type_id_foreign` (`_account_type_id`),
  ADD KEY `warranty_accounts__account_group_id_foreign` (`_account_group_id`),
  ADD KEY `warranty_accounts__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `warranty_accounts__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `warranty_details`
--
ALTER TABLE `warranty_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warranty_details__item_id_foreign` (`_item_id`),
  ADD KEY `warranty_details__no_foreign` (`_no`),
  ADD KEY `warranty_details__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `warranty_form_settings`
--
ALTER TABLE `warranty_form_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warranty_masters`
--
ALTER TABLE `warranty_masters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warranty_masters__ledger_id_foreign` (`_ledger_id`),
  ADD KEY `warranty_masters__user_id_foreign` (`_user_id`),
  ADD KEY `warranty_masters__branch_id_foreign` (`_branch_id`);

--
-- Indexes for table `warrenty_dates`
--
ALTER TABLE `warrenty_dates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workorders`
--
ALTER TABLE `workorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workorders_master`
--
ALTER TABLE `workorders_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_details`
--
ALTER TABLE `account_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_groups`
--
ALTER TABLE `account_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `account_group_configs`
--
ALTER TABLE `account_group_configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `account_heads`
--
ALTER TABLE `account_heads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `account_ledgers`
--
ALTER TABLE `account_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=513;

--
-- AUTO_INCREMENT for table `assets_conditions`
--
ALTER TABLE `assets_conditions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assets_device_locations`
--
ALTER TABLE `assets_device_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assets_locations`
--
ALTER TABLE `assets_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_assigns`
--
ALTER TABLE `asset_assigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `asset_depreciations`
--
ALTER TABLE `asset_depreciations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `asset_depreciation_details`
--
ALTER TABLE `asset_depreciation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `asset_eng_consumptions`
--
ALTER TABLE `asset_eng_consumptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `asset_images`
--
ALTER TABLE `asset_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asset_import_costs`
--
ALTER TABLE `asset_import_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `asset_import_cost_details`
--
ALTER TABLE `asset_import_cost_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `asset_inspections`
--
ALTER TABLE `asset_inspections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `asset_items`
--
ALTER TABLE `asset_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `asset_maintainces`
--
ALTER TABLE `asset_maintainces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_sales`
--
ALTER TABLE `asset_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assign_leaves`
--
ALTER TABLE `assign_leaves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assign_statuses`
--
ALTER TABLE `assign_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bank_check_infos`
--
ALTER TABLE `bank_check_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `barcode_details`
--
ALTER TABLE `barcode_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bonus_item_details`
--
ALTER TABLE `bonus_item_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_details`
--
ALTER TABLE `budget_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_item_details`
--
ALTER TABLE `budget_item_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_revisions`
--
ALTER TABLE `budget_revisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_revision_details`
--
ALTER TABLE `budget_revision_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_revision_item_details`
--
ALTER TABLE `budget_revision_item_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cat_wise_ta_bills`
--
ALTER TABLE `cat_wise_ta_bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cost_centers`
--
ALTER TABLE `cost_centers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cost_center_authorised_chains`
--
ALTER TABLE `cost_center_authorised_chains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `current_salary_masters`
--
ALTER TABLE `current_salary_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `current_salary_structures`
--
ALTER TABLE `current_salary_structures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `cylindars`
--
ALTER TABLE `cylindars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cylindar_location_histories`
--
ALTER TABLE `cylindar_location_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cylinder_product_price_lists`
--
ALTER TABLE `cylinder_product_price_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `damage_adjustments`
--
ALTER TABLE `damage_adjustments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damage_adjustment_details`
--
ALTER TABLE `damage_adjustment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damage_barcodes`
--
ALTER TABLE `damage_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damage_form_settings`
--
ALTER TABLE `damage_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damage_from_stocks`
--
ALTER TABLE `damage_from_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `damage_from_stock_barcodes`
--
ALTER TABLE `damage_from_stock_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `damage_from_stock_details`
--
ALTER TABLE `damage_from_stock_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `damage_item_histories`
--
ALTER TABLE `damage_item_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `damage_receive_accounts`
--
ALTER TABLE `damage_receive_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damage_receive_barcodes`
--
ALTER TABLE `damage_receive_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `damage_receive_details`
--
ALTER TABLE `damage_receive_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `damage_receive_form_settings`
--
ALTER TABLE `damage_receive_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damage_receive_masters`
--
ALTER TABLE `damage_receive_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damage_send_accounts`
--
ALTER TABLE `damage_send_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `damage_send_barcodes`
--
ALTER TABLE `damage_send_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damage_send_details`
--
ALTER TABLE `damage_send_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damage_send_form_settings`
--
ALTER TABLE `damage_send_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damage_send_masters`
--
ALTER TABLE `damage_send_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `default_ledgers`
--
ALTER TABLE `default_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `direct_manufature_row_goods`
--
ALTER TABLE `direct_manufature_row_goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direct_productions`
--
ALTER TABLE `direct_productions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direct_production_barcodes`
--
ALTER TABLE `direct_production_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `direct_production_finis_goods`
--
ALTER TABLE `direct_production_finis_goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_duties`
--
ALTER TABLE `employee_duties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `free_item_setups`
--
ALTER TABLE `free_item_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `honorarium_bills`
--
ALTER TABLE `honorarium_bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `honorarium_bill_details`
--
ALTER TABLE `honorarium_bill_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `honorarium_payments`
--
ALTER TABLE `honorarium_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `honorarium_payment_details`
--
ALTER TABLE `honorarium_payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `honorim_setups`
--
ALTER TABLE `honorim_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `hrm_attendances`
--
ALTER TABLE `hrm_attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hrm_departments`
--
ALTER TABLE `hrm_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hrm_education`
--
ALTER TABLE `hrm_education`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_emergencies`
--
ALTER TABLE `hrm_emergencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_empaddresses`
--
ALTER TABLE `hrm_empaddresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_employees`
--
ALTER TABLE `hrm_employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `hrm_emp_categories`
--
ALTER TABLE `hrm_emp_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `hrm_emp_locations`
--
ALTER TABLE `hrm_emp_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `hrm_experiences`
--
ALTER TABLE `hrm_experiences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_grades`
--
ALTER TABLE `hrm_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `hrm_guarantors`
--
ALTER TABLE `hrm_guarantors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_holidays`
--
ALTER TABLE `hrm_holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_holiday_details`
--
ALTER TABLE `hrm_holiday_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_itaxconfigs`
--
ALTER TABLE `hrm_itaxconfigs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_itaxledgers`
--
ALTER TABLE `hrm_itaxledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_itaxpayables`
--
ALTER TABLE `hrm_itaxpayables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_itaxrebates`
--
ALTER TABLE `hrm_itaxrebates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_jobcontracts`
--
ALTER TABLE `hrm_jobcontracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hrm_jobs`
--
ALTER TABLE `hrm_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_jobtitles`
--
ALTER TABLE `hrm_jobtitles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_languages`
--
ALTER TABLE `hrm_languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_leavebalances`
--
ALTER TABLE `hrm_leavebalances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_leaveentitlements`
--
ALTER TABLE `hrm_leaveentitlements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_leavetypes`
--
ALTER TABLE `hrm_leavetypes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hrm_monthly_salary_details`
--
ALTER TABLE `hrm_monthly_salary_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_monthly_salary_masters`
--
ALTER TABLE `hrm_monthly_salary_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_nominees`
--
ALTER TABLE `hrm_nominees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hrm_payheads`
--
ALTER TABLE `hrm_payheads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `hrm_payinfos`
--
ALTER TABLE `hrm_payinfos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_payunits`
--
ALTER TABLE `hrm_payunits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_pay_head_types`
--
ALTER TABLE `hrm_pay_head_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `hrm_profitcenters`
--
ALTER TABLE `hrm_profitcenters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_recruitments`
--
ALTER TABLE `hrm_recruitments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_rewards`
--
ALTER TABLE `hrm_rewards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_salarystructures`
--
ALTER TABLE `hrm_salarystructures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_sstructuredetails`
--
ALTER TABLE `hrm_sstructuredetails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_trainings`
--
ALTER TABLE `hrm_trainings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_transfers`
--
ALTER TABLE `hrm_transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_vacancies`
--
ALTER TABLE `hrm_vacancies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hrm_weekworkdays`
--
ALTER TABLE `hrm_weekworkdays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `import_cost_accounts`
--
ALTER TABLE `import_cost_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `import_cost_ledgers`
--
ALTER TABLE `import_cost_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `import_puchases`
--
ALTER TABLE `import_puchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_puchase_accounts`
--
ALTER TABLE `import_puchase_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_puchase_barcodes`
--
ALTER TABLE `import_puchase_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_puchase_details`
--
ALTER TABLE `import_puchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `import_puchase_form_settings`
--
ALTER TABLE `import_puchase_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `import_receive_vessel_infos`
--
ALTER TABLE `import_receive_vessel_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incentive_earn_ledger_details`
--
ALTER TABLE `incentive_earn_ledger_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incentive_earn_masters`
--
ALTER TABLE `incentive_earn_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `individual_replace_form_settings`
--
ALTER TABLE `individual_replace_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `individual_replace_in_accounts`
--
ALTER TABLE `individual_replace_in_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `individual_replace_in_items`
--
ALTER TABLE `individual_replace_in_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `individual_replace_masters`
--
ALTER TABLE `individual_replace_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `individual_replace_old_items`
--
ALTER TABLE `individual_replace_old_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `individual_replace_out_accounts`
--
ALTER TABLE `individual_replace_out_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `individual_replace_out_items`
--
ALTER TABLE `individual_replace_out_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inspection_check_categories`
--
ALTER TABLE `inspection_check_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inspection_check_lists`
--
ALTER TABLE `inspection_check_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_prefixes`
--
ALTER TABLE `invoice_prefixes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `item_balance_without_lots`
--
ALTER TABLE `item_balance_without_lots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `item_bonus_setups`
--
ALTER TABLE `item_bonus_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `item_brands`
--
ALTER TABLE `item_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_inventories`
--
ALTER TABLE `item_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item_pack_sizes`
--
ALTER TABLE `item_pack_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `item_rate_histories`
--
ALTER TABLE `item_rate_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=295;

--
-- AUTO_INCREMENT for table `item_rate_history_logs`
--
ALTER TABLE `item_rate_history_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `item_types`
--
ALTER TABLE `item_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kitchens`
--
ALTER TABLE `kitchens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kitchen_finish_goods`
--
ALTER TABLE `kitchen_finish_goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kitchen_row_goods`
--
ALTER TABLE `kitchen_row_goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `language_meta`
--
ALTER TABLE `language_meta`
  MODIFY `lang_meta_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `lc_amendments`
--
ALTER TABLE `lc_amendments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lc_amendment_types`
--
ALTER TABLE `lc_amendment_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lc_items`
--
ALTER TABLE `lc_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lc_item_costs`
--
ALTER TABLE `lc_item_costs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `lc_masters`
--
ALTER TABLE `lc_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `main_account_head`
--
ALTER TABLE `main_account_head`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `material_issues`
--
ALTER TABLE `material_issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_issue_barcodes`
--
ALTER TABLE `material_issue_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_issue_details`
--
ALTER TABLE `material_issue_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `material_issue_returns`
--
ALTER TABLE `material_issue_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_issue_return_barcodes`
--
ALTER TABLE `material_issue_return_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_issue_return_details`
--
ALTER TABLE `material_issue_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_issue_return_settings`
--
ALTER TABLE `material_issue_return_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `material_issue_settings`
--
ALTER TABLE `material_issue_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=278;

--
-- AUTO_INCREMENT for table `monthly_sales_targets`
--
ALTER TABLE `monthly_sales_targets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `mother_vessels`
--
ALTER TABLE `mother_vessels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `musak_four_point_threes`
--
ALTER TABLE `musak_four_point_threes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `musak_four_point_three_additions`
--
ALTER TABLE `musak_four_point_three_additions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `musak_four_point_three_inputs`
--
ALTER TABLE `musak_four_point_three_inputs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notesheets`
--
ALTER TABLE `notesheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notesheets_master`
--
ALTER TABLE `notesheets_master`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notesheet_account_details`
--
ALTER TABLE `notesheet_account_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notesheet_remarks_history`
--
ALTER TABLE `notesheet_remarks_history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization_branches`
--
ALTER TABLE `organization_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `organization_branch_stores`
--
ALTER TABLE `organization_branch_stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization_cost_centers`
--
ALTER TABLE `organization_cost_centers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `organization_departments`
--
ALTER TABLE `organization_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `organization_department_designations`
--
ALTER TABLE `organization_department_designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organization_designations`
--
ALTER TABLE `organization_designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `organization_stores`
--
ALTER TABLE `organization_stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `org_branch_items`
--
ALTER TABLE `org_branch_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_rows`
--
ALTER TABLE `page_rows`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `payment_receive_details`
--
ALTER TABLE `payment_receive_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_receive_masters`
--
ALTER TABLE `payment_receive_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=789;

--
-- AUTO_INCREMENT for table `postcodes`
--
ALTER TABLE `postcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1350;

--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `productions`
--
ALTER TABLE `productions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `production_from_settings`
--
ALTER TABLE `production_from_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `production_partial_receives`
--
ALTER TABLE `production_partial_receives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_status`
--
ALTER TABLE `production_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_incentive_earns`
--
ALTER TABLE `product_incentive_earns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_price_lists`
--
ALTER TABLE `product_price_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proforma_sales`
--
ALTER TABLE `proforma_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proforma_sales_details`
--
ALTER TABLE `proforma_sales_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_management`
--
ALTER TABLE `project_management`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_accounts`
--
ALTER TABLE `purchase_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_barcodes`
--
ALTER TABLE `purchase_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_form_settings`
--
ALTER TABLE `purchase_form_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_accounts`
--
ALTER TABLE `purchase_order_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_order_details`
--
ALTER TABLE `purchase_order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_accounts`
--
ALTER TABLE `purchase_return_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_barcodes`
--
ALTER TABLE `purchase_return_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_return_form_settings`
--
ALTER TABLE `purchase_return_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quaterly_individual_insentives`
--
ALTER TABLE `quaterly_individual_insentives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quaterly_insentive_setups`
--
ALTER TABLE `quaterly_insentive_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `receive_payments`
--
ALTER TABLE `receive_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `receive_payment_details`
--
ALTER TABLE `receive_payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `replacement_form_settings`
--
ALTER TABLE `replacement_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `replacement_item_accounts`
--
ALTER TABLE `replacement_item_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `replacement_item_ins`
--
ALTER TABLE `replacement_item_ins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `replacement_item_outs`
--
ALTER TABLE `replacement_item_outs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `replacement_masters`
--
ALTER TABLE `replacement_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rep_in_barcodes`
--
ALTER TABLE `rep_in_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rep_out_barcodes`
--
ALTER TABLE `rep_out_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant_category_settings`
--
ALTER TABLE `restaurant_category_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `resturant_details`
--
ALTER TABLE `resturant_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resturant_form_settings`
--
ALTER TABLE `resturant_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `resturant_sales`
--
ALTER TABLE `resturant_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resturant_sales_accounts`
--
ALTER TABLE `resturant_sales_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rlp_access_chains`
--
ALTER TABLE `rlp_access_chains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rlp_access_chain_users`
--
ALTER TABLE `rlp_access_chain_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `rlp_account_details`
--
ALTER TABLE `rlp_account_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rlp_acknowledgements`
--
ALTER TABLE `rlp_acknowledgements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rlp_delete_histories`
--
ALTER TABLE `rlp_delete_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rlp_details`
--
ALTER TABLE `rlp_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rlp_masters`
--
ALTER TABLE `rlp_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rlp_remarks`
--
ALTER TABLE `rlp_remarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rlp_user_groups`
--
ALTER TABLE `rlp_user_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `saif_employee_db`
--
ALTER TABLE `saif_employee_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_sheets`
--
ALTER TABLE `salary_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_accounts`
--
ALTER TABLE `sales_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_barcodes`
--
ALTER TABLE `sales_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_commision_plans`
--
ALTER TABLE `sales_commision_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales_commision_plan_details`
--
ALTER TABLE `sales_commision_plan_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sales_details`
--
ALTER TABLE `sales_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_form_settings`
--
ALTER TABLE `sales_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_orders`
--
ALTER TABLE `sales_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_order_details`
--
ALTER TABLE `sales_order_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_returns`
--
ALTER TABLE `sales_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_accounts`
--
ALTER TABLE `sales_return_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_barcodes`
--
ALTER TABLE `sales_return_barcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_details`
--
ALTER TABLE `sales_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_form_settings`
--
ALTER TABLE `sales_return_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_return_wlms`
--
ALTER TABLE `sales_return_wlms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_wlm_accounts`
--
ALTER TABLE `sales_return_wlm_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_return_wlm_details`
--
ALTER TABLE `sales_return_wlm_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_without_lots`
--
ALTER TABLE `sales_without_lots`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_without_lot_accounts`
--
ALTER TABLE `sales_without_lot_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_without_lot_details`
--
ALTER TABLE `sales_without_lot_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_deposits`
--
ALTER TABLE `security_deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `service_accounts`
--
ALTER TABLE `service_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_details`
--
ALTER TABLE `service_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_from_settings`
--
ALTER TABLE `service_from_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `service_masters`
--
ALTER TABLE `service_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setting_key_values`
--
ALTER TABLE `setting_key_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_media`
--
ALTER TABLE `social_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sold_item_stock`
--
ALTER TABLE `sold_item_stock`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_details`
--
ALTER TABLE `status_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `steward_allocations`
--
ALTER TABLE `steward_allocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stm_bill_collections`
--
ALTER TABLE `stm_bill_collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stm_bill_masters`
--
ALTER TABLE `stm_bill_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stm_bill_master_details`
--
ALTER TABLE `stm_bill_master_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stm_classes`
--
ALTER TABLE `stm_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `stm_collection_masters`
--
ALTER TABLE `stm_collection_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stm_collection_master_details`
--
ALTER TABLE `stm_collection_master_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stm_divisions`
--
ALTER TABLE `stm_divisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stm_division_class_students`
--
ALTER TABLE `stm_division_class_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `stm_education_sessions`
--
ALTER TABLE `stm_education_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stm_income_ledger_setups`
--
ALTER TABLE `stm_income_ledger_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stm_students`
--
ALTER TABLE `stm_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `stm_subjects`
--
ALTER TABLE `stm_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stock_ins`
--
ALTER TABLE `stock_ins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_outs`
--
ALTER TABLE `stock_outs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_houses`
--
ALTER TABLE `store_houses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_house_selves`
--
ALTER TABLE `store_house_selves`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_class_subjects`
--
ALTER TABLE `student_class_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `supplier_payment_details`
--
ALTER TABLE `supplier_payment_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `table_infos`
--
ALTER TABLE `table_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ta_da_setups`
--
ALTER TABLE `ta_da_setups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_cus_categories`
--
ALTER TABLE `tbl_cus_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transection_terms`
--
ALTER TABLE `transection_terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `unit_conversions`
--
ALTER TABLE `unit_conversions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upazilas`
--
ALTER TABLE `upazilas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=496;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=517;

--
-- AUTO_INCREMENT for table `user_login_histories`
--
ALTER TABLE `user_login_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1530;

--
-- AUTO_INCREMENT for table `vat_rules`
--
ALTER TABLE `vat_rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vessel_infos`
--
ALTER TABLE `vessel_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vessel_routes`
--
ALTER TABLE `vessel_routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vouchar_check_infos`
--
ALTER TABLE `vouchar_check_infos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_masters`
--
ALTER TABLE `voucher_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_master_details`
--
ALTER TABLE `voucher_master_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_types`
--
ALTER TABLE `voucher_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `warranties`
--
ALTER TABLE `warranties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `warranty_accounts`
--
ALTER TABLE `warranty_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warranty_details`
--
ALTER TABLE `warranty_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warranty_form_settings`
--
ALTER TABLE `warranty_form_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warranty_masters`
--
ALTER TABLE `warranty_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warrenty_dates`
--
ALTER TABLE `warrenty_dates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workorders`
--
ALTER TABLE `workorders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workorders_master`
--
ALTER TABLE `workorders_master`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_groups`
--
ALTER TABLE `account_groups`
  ADD CONSTRAINT `account_groups__account_head_id_foreign` FOREIGN KEY (`_account_head_id`) REFERENCES `account_heads` (`id`);

--
-- Constraints for table `account_ledgers`
--
ALTER TABLE `account_ledgers`
  ADD CONSTRAINT `account_ledgers__account_group_id_foreign` FOREIGN KEY (`_account_group_id`) REFERENCES `account_groups` (`id`);

--
-- Constraints for table `damage_item_histories`
--
ALTER TABLE `damage_item_histories`
  ADD CONSTRAINT `damage_item_histories__branch_id_foreign` FOREIGN KEY (`_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `damage_item_histories__item_id_foreign` FOREIGN KEY (`_item_id`) REFERENCES `inventories` (`id`);

--
-- Constraints for table `damage_receive_accounts`
--
ALTER TABLE `damage_receive_accounts`
  ADD CONSTRAINT `damage_receive_accounts__account_group_id_foreign` FOREIGN KEY (`_account_group_id`) REFERENCES `account_groups` (`id`),
  ADD CONSTRAINT `damage_receive_accounts__account_type_id_foreign` FOREIGN KEY (`_account_type_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `damage_receive_accounts__branch_id_foreign` FOREIGN KEY (`_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `damage_receive_accounts__ledger_id_foreign` FOREIGN KEY (`_ledger_id`) REFERENCES `account_ledgers` (`id`),
  ADD CONSTRAINT `damage_receive_accounts__no_foreign` FOREIGN KEY (`_no`) REFERENCES `damage_receive_masters` (`id`);

--
-- Constraints for table `damage_receive_details`
--
ALTER TABLE `damage_receive_details`
  ADD CONSTRAINT `damage_receive_details__branch_id_foreign` FOREIGN KEY (`_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `damage_receive_details__item_id_foreign` FOREIGN KEY (`_item_id`) REFERENCES `inventories` (`id`),
  ADD CONSTRAINT `damage_receive_details__no_foreign` FOREIGN KEY (`_no`) REFERENCES `damage_receive_masters` (`id`);

--
-- Constraints for table `damage_receive_masters`
--
ALTER TABLE `damage_receive_masters`
  ADD CONSTRAINT `damage_receive_masters__branch_id_foreign` FOREIGN KEY (`_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `damage_receive_masters__ledger_id_foreign` FOREIGN KEY (`_ledger_id`) REFERENCES `account_ledgers` (`id`),
  ADD CONSTRAINT `damage_receive_masters__user_id_foreign` FOREIGN KEY (`_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `damage_send_accounts`
--
ALTER TABLE `damage_send_accounts`
  ADD CONSTRAINT `damage_send_accounts__account_group_id_foreign` FOREIGN KEY (`_account_group_id`) REFERENCES `account_groups` (`id`),
  ADD CONSTRAINT `damage_send_accounts__account_type_id_foreign` FOREIGN KEY (`_account_type_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `damage_send_accounts__branch_id_foreign` FOREIGN KEY (`_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `damage_send_accounts__ledger_id_foreign` FOREIGN KEY (`_ledger_id`) REFERENCES `account_ledgers` (`id`),
  ADD CONSTRAINT `damage_send_accounts__no_foreign` FOREIGN KEY (`_no`) REFERENCES `damage_send_masters` (`id`);

--
-- Constraints for table `damage_send_details`
--
ALTER TABLE `damage_send_details`
  ADD CONSTRAINT `damage_send_details__branch_id_foreign` FOREIGN KEY (`_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `damage_send_details__item_id_foreign` FOREIGN KEY (`_item_id`) REFERENCES `inventories` (`id`),
  ADD CONSTRAINT `damage_send_details__no_foreign` FOREIGN KEY (`_no`) REFERENCES `damage_send_masters` (`id`);

--
-- Constraints for table `damage_send_masters`
--
ALTER TABLE `damage_send_masters`
  ADD CONSTRAINT `damage_send_masters__branch_id_foreign` FOREIGN KEY (`_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `damage_send_masters__ledger_id_foreign` FOREIGN KEY (`_ledger_id`) REFERENCES `account_ledgers` (`id`),
  ADD CONSTRAINT `damage_send_masters__user_id_foreign` FOREIGN KEY (`_user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `import_cost_accounts`
--
ALTER TABLE `import_cost_accounts`
  ADD CONSTRAINT `import_cost_accounts__account_group_id_foreign` FOREIGN KEY (`_account_group_id`) REFERENCES `account_groups` (`id`),
  ADD CONSTRAINT `import_cost_accounts__account_type_id_foreign` FOREIGN KEY (`_account_type_id`) REFERENCES `account_heads` (`id`),
  ADD CONSTRAINT `import_cost_accounts__branch_id_foreign` FOREIGN KEY (`_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `import_cost_accounts__ledger_id_foreign` FOREIGN KEY (`_ledger_id`) REFERENCES `account_ledgers` (`id`);

--
-- Constraints for table `lc_amendments`
--
ALTER TABLE `lc_amendments`
  ADD CONSTRAINT `lc_amendments_lc_master_id_foreign` FOREIGN KEY (`lc_master_id`) REFERENCES `lc_masters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lc_items`
--
ALTER TABLE `lc_items`
  ADD CONSTRAINT `lc_items_lc_master_id_foreign` FOREIGN KEY (`lc_master_id`) REFERENCES `lc_masters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lc_item_costs`
--
ALTER TABLE `lc_item_costs`
  ADD CONSTRAINT `lc_item_costs_lc_master_id_foreign` FOREIGN KEY (`lc_master_id`) REFERENCES `lc_masters` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_receive_masters`
--
ALTER TABLE `payment_receive_masters`
  ADD CONSTRAINT `payment_receive_masters__branch_id_foreign` FOREIGN KEY (`_branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `payment_receive_masters__user_id_foreign` FOREIGN KEY (`_user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
