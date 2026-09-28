-- Fidak TinyML upgrade
-- Run this ONCE after importing the original fidak_bbms_db.sql.

ALTER TABLE donor_details
    ADD COLUMN total_donations INT NOT NULL DEFAULT 0 AFTER donor_address,
    ADD COLUMN last_donation_date DATE NULL AFTER total_donations,
    ADD COLUMN first_donation_date DATE NULL AFTER last_donation_date;

-- Add indexes used by donor matching.
CREATE INDEX idx_donor_blood ON donor_details (donor_blood);
CREATE INDEX idx_total_donations ON donor_details (total_donations);
