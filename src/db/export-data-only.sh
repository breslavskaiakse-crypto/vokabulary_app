#!/bin/bash
# Script to export only data (no structure) for seeding
# Usage: ./export-data-only.sh

BACKUP_DIR="/var/www/html/src/db/seeds"
BACKUP_FILE="${BACKUP_DIR}/data_export_$(date +%Y%m%d_%H%M%S).sql"

# Database credentials
DB_HOST="mysql"
DB_NAME="mydatabase"
DB_USER="myuser"
DB_PASS="mypassword"

echo "Exporting database data (no structure)..."

# Create seeds directory if it doesn't exist
mkdir -p "${BACKUP_DIR}"

# Export only data (INSERT statements, no CREATE TABLE)
mysqldump -h "${DB_HOST}" -u "${DB_USER}" -p"${DB_PASS}" \
    --no-create-info \
    --skip-triggers \
    --skip-routines \
    --skip-events \
    --single-transaction \
    "${DB_NAME}" > "${BACKUP_FILE}"

if [ $? -eq 0 ]; then
    echo "✓ Data export created successfully: ${BACKUP_FILE}"
    echo "File size: $(du -h "${BACKUP_FILE}" | cut -f1)"
    echo ""
    echo "This file can be used as a Phinx seed file."
else
    echo "✗ Export failed!"
    exit 1
fi


