USE cfsys_db;

INSERT INTO users (name, username, email, password, role, status, lang_pref) VALUES
('Admin User', 'admin', 'admin@example.com', '$2y$10$T.v8lFfF7lB7lV1lV1lV1.v8lFfF7lB7lV1lV1lV1lV1lV1lV1lV1', 'admin', 'active', 'en'),

INSERT INTO services (name_ar, name_en) VALUES
('خدمة 1', 'Service 1'),
('خدمة 2', 'Service 2'),
('خدمة 3', 'Service 3');

INSERT INTO service_statuses (service_id, name_ar, name_en, sort_order, type) VALUES
(1, 'جديد', 'New', 1, 'neutral'),
(1, 'قيد المعالجة', 'In Progress', 2, 'neutral'),
(1, 'بانتظار الوثائق', 'Awaiting Documents', 3, 'neutral'),
(1, 'تم الإنجاز', 'Completed', 4, 'won'),
(1, 'ملغي', 'Cancelled', 5, 'lost');

INSERT INTO service_statuses (service_id, name_ar, name_en, sort_order, type) VALUES
(2, 'تواصل أولي', 'Initial Contact', 1, 'neutral'),
(2, 'تقديم عرض تجريبي', 'Demo Scheduled', 2, 'neutral'),
(2, 'ارسال عرض سعر', 'Quotation Sent', 3, 'neutral'),
(2, 'مفاوضات', 'Negotiation', 4, 'neutral'),
(2, 'تم البيع', 'Closed Won', 5, 'won'),
(2, 'خسارة العميل', 'Closed Lost', 6, 'lost');

INSERT INTO service_statuses (service_id, name_ar, name_en, sort_order, type) VALUES
(3, 'استفسار جديد', 'New Inquiry', 1, 'neutral'),
(3, 'تحليل المتطلبات', 'Requirement Analysis', 2, 'neutral'),
(3, 'في مرحلة التصميم', 'Design Phase', 3, 'neutral'),
(3, 'قيد التطوير', 'Development', 4, 'neutral'),
(3, 'تم التسليم', 'Delivered', 5, 'won'),
(3, 'رفض المشروع', 'Rejected', 6, 'lost');

INSERT INTO sources (name_ar, name_en) VALUES
('فيسبوك', 'Facebook'),
('واتساب', 'WhatsApp'),
('اتصال هاتفي', 'Phone Call'),
('الموقع الإلكتروني', 'Website'),
('توصية (ريفرال)', 'Referral'),
('أخرى', 'Other');
