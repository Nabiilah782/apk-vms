<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama
     */
    public function index()
    {
        // Data untuk My Products
        $products = [
            [
                'id' => 1,
                'name' => 'mywdellas.com',
                'description' => 'WordPress Hosting',
                'status' => 'active',
                'icon' => 'bi-wordpress'
            ],
            [
                'id' => 2,
                'name' => 'mywdellas.com',
                'description' => 'Weekly Backups',
                'status' => 'active',
                'icon' => 'bi-cloud-arrow-up'
            ],
            [
                'id' => 3,
                'name' => 'flowarchs.com',
                'description' => 'Premium Hosting',
                'status' => 'active',
                'icon' => 'bi-server'
            ],
        ];

        // Data untuk Invoicing
        $invoices = [
            [
                'id' => 'AS350067',
                'package' => 'CS: 4000771 Drive/HeadShop',
                'due_date' => '2025-02-20',
                'total' => '$999.00',
                'domain' => 'twoflowarchs.com',
                'expiration' => '2026-02-26',
                'status' => 'pending'
            ],
            [
                'id' => '40188878',
                'package' => 'Mr: 9790633 Field, Lincoln',
                'due_date' => '2025-05-15',
                'total' => '$879.00',
                'domain' => 'www.flowarchs.com',
                'expiration' => '2026-06-28',
                'status' => 'paid'
            ],
            [
                'id' => '4018899',
                'package' => 'Mr: 9790644 Field, Lincoln',
                'due_date' => '2025-06-10',
                'total' => '$879.00',
                'domain' => 'jameshoulding.com',
                'expiration' => '2026-06-28',
                'status' => 'paid'
            ],
        ];

        // Data untuk Video Guides & Tips
        $guides = [
            [
                'id' => 1,
                'title' => '5 tips to make your site easier to find on search',
                'description' => 'Learn how to optimize your website for better search engine visibility.',
                'duration' => '8:45',
                'category' => 'SEO'
            ],
            [
                'id' => 2,
                'title' => 'Setting up your first theme on WordPress',
                'description' => 'A step-by-step guide to installing and customizing your WordPress theme.',
                'duration' => '12:30',
                'category' => 'WordPress'
            ],
            [
                'id' => 3,
                'title' => '5 ways to increase traffic to your online store',
                'description' => 'Effective strategies to drive more visitors to your e-commerce site.',
                'duration' => '15:20',
                'category' => 'Marketing'
            ],
            [
                'id' => 4,
                'title' => 'Securing your website from common threats',
                'description' => 'Essential security practices to protect your online presence.',
                'duration' => '10:15',
                'category' => 'Security'
            ],
            [
                'id' => 5,
                'title' => 'Maximizing your hosting performance',
                'description' => 'Tips to ensure your website loads quickly and reliably.',
                'duration' => '9:30',
                'category' => 'Performance'
            ],
        ];

        // Data untuk Account Overview
        $stats = [
            'active_products' => 3,
            'total_billing' => '$2,757',
            'pending_invoices' => 1,
            'completed_guides' => 12
        ];

        return view('dashboard.index', compact('products', 'invoices', 'guides', 'stats'));
    }

    /**
     * Menampilkan halaman semua produk
     */
    public function products()
    {
        // Data dummy untuk halaman products
        $allProducts = [
            [
                'id' => 1,
                'name' => 'mywdellas.com',
                'type' => 'WordPress Hosting',
                'status' => 'active',
                'plan' => 'Business',
                'renewal_date' => '2025-12-28',
                'price' => '$29.99/mo'
            ],
            [
                'id' => 2,
                'name' => 'mywdellas.com',
                'type' => 'Weekly Backups',
                'status' => 'active',
                'plan' => 'Add-on',
                'renewal_date' => '2025-12-28',
                'price' => '$9.99/mo'
            ],
            [
                'id' => 3,
                'name' => 'flowarchs.com',
                'type' => 'Premium Hosting',
                'status' => 'active',
                'plan' => 'Enterprise',
                'renewal_date' => '2026-01-15',
                'price' => '$99.99/mo'
            ],
            [
                'id' => 4,
                'name' => 'jameshoulding.com',
                'type' => 'Basic Hosting',
                'status' => 'suspended',
                'plan' => 'Starter',
                'renewal_date' => '2025-11-30',
                'price' => '$14.99/mo'
            ],
        ];

        return view('dashboard.products', compact('allProducts'));
    }

    /**
     * Menampilkan halaman semua invoice
     */
    public function invoices()
    {
        // Data dummy untuk halaman invoices
        $allInvoices = [
            [
                'invoice_number' => 'INV-2023-001',
                'date' => '2023-01-15',
                'customer' => 'Martin Doe',
                'amount' => '$299.99',
                'status' => 'paid',
                'due_date' => '2023-01-30'
            ],
            [
                'invoice_number' => 'INV-2023-002',
                'date' => '2023-02-15',
                'customer' => 'Martin Doe',
                'amount' => '$299.99',
                'status' => 'paid',
                'due_date' => '2023-02-28'
            ],
            [
                'invoice_number' => 'INV-2023-003',
                'date' => '2023-03-15',
                'customer' => 'Martin Doe',
                'amount' => '$299.99',
                'status' => 'paid',
                'due_date' => '2023-03-31'
            ],
            [
                'invoice_number' => 'INV-2023-004',
                'date' => '2023-04-15',
                'customer' => 'Martin Doe',
                'amount' => '$299.99',
                'status' => 'paid',
                'due_date' => '2023-04-30'
            ],
            [
                'invoice_number' => 'INV-2023-005',
                'date' => '2023-05-15',
                'customer' => 'Martin Doe',
                'amount' => '$299.99',
                'status' => 'pending',
                'due_date' => '2023-05-31'
            ],
        ];

        return view('dashboard.invoices', compact('allInvoices'));
    }

    /**
     * Menampilkan halaman support
     */
    public function support()
    {
        // Data dummy untuk halaman support
        $tickets = [
            [
                'id' => 'TKT-001',
                'subject' => 'WordPress Installation Issue',
                'status' => 'open',
                'priority' => 'high',
                'created_at' => '2023-10-15',
                'last_update' => '2023-10-16'
            ],
            [
                'id' => 'TKT-002',
                'subject' => 'Domain Configuration',
                'status' => 'resolved',
                'priority' => 'medium',
                'created_at' => '2023-10-10',
                'last_update' => '2023-10-12'
            ],
            [
                'id' => 'TKT-003',
                'subject' => 'SSL Certificate Renewal',
                'status' => 'in_progress',
                'priority' => 'medium',
                'created_at' => '2023-10-18',
                'last_update' => '2023-10-19'
            ],
        ];

        return view('dashboard.support', compact('tickets'));
    }

    /**
     * Menampilkan halaman settings
     */
    public function settings()
    {
        // Data dummy untuk halaman settings
        $user = [
            'name' => 'Martin Doe',
            'email' => 'martin@example.com',
            'phone' => '+1 (555) 123-4567',
            'company' => 'WebSolutions Inc.',
            'address' => '123 Tech Street, San Francisco, CA 94107',
            'account_type' => 'Business',
            'joined_date' => '2022-05-15'
        ];

        $preferences = [
            'email_notifications' => true,
            'sms_notifications' => false,
            'monthly_report' => true,
            'invoice_reminders' => true,
            'product_updates' => true
        ];

        return view('dashboard.settings', compact('user', 'preferences'));
    }

    /**
     * Menampilkan halaman semua guides
     */
    public function guides()
    {
        // Data dummy untuk halaman guides
        $allGuides = [
            [
                'id' => 1,
                'title' => 'Getting Started with WordPress',
                'description' => 'Complete guide to setting up your first WordPress site.',
                'category' => 'WordPress',
                'duration' => '25:45',
                'level' => 'Beginner',
                'views' => 1245
            ],
            [
                'id' => 2,
                'title' => 'Advanced SEO Techniques',
                'description' => 'Learn advanced SEO strategies to rank higher in search engines.',
                'category' => 'SEO',
                'duration' => '42:30',
                'level' => 'Advanced',
                'views' => 892
            ],
            [
                'id' => 3,
                'title' => 'Website Security Best Practices',
                'description' => 'Protect your website from common security threats.',
                'category' => 'Security',
                'duration' => '18:20',
                'level' => 'Intermediate',
                'views' => 1567
            ],
            [
                'id' => 4,
                'title' => 'E-commerce Optimization',
                'description' => 'Maximize sales and conversions on your online store.',
                'category' => 'E-commerce',
                'duration' => '35:15',
                'level' => 'Intermediate',
                'views' => 743
            ],
            [
                'id' => 5,
                'title' => 'Website Performance Tuning',
                'description' => 'Speed up your website for better user experience.',
                'category' => 'Performance',
                'duration' => '22:10',
                'level' => 'Intermediate',
                'views' => 1102
            ],
        ];

        return view('dashboard.guides', compact('allGuides'));
    }

    /**
     * Menampilkan detail produk
     */
    public function showProduct($id)
    {
        // Logika untuk menampilkan detail produk
        return view('dashboard.product-detail', ['id' => $id]);
    }

    /**
     * Menampilkan detail invoice
     */
    public function showInvoice($id)
    {
        // Logika untuk menampilkan detail invoice
        return view('dashboard.invoice-detail', ['id' => $id]);
    }

    /**
     * Menampilkan detail guide
     */
    public function showGuide($id)
    {
        // Logika untuk menampilkan detail guide
        return view('dashboard.guide-detail', ['id' => $id]);
    }

    /**
     * API untuk mendapatkan data statistik dashboard (jika dibutuhkan)
     */
    public function getStats()
    {
        $stats = [
            'total_products' => 3,
            'active_invoices' => 1,
            'total_revenue' => '$2,757',
            'support_tickets' => 3,
            'completed_guides' => 12,
            'uptime_percentage' => '99.9%'
        ];

        return response()->json($stats);
    }

    /**
     * API untuk update user preferences
     */
    public function updatePreferences(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'monthly_report' => 'boolean',
            'invoice_reminders' => 'boolean',
            'product_updates' => 'boolean'
        ]);

        // Di sini Anda akan menyimpan preferences ke database
        // Contoh: Auth::user()->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Preferences updated successfully',
            'data' => $validated
        ]);
    }
}