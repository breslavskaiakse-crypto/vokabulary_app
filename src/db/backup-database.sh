#!/bin/bash
# Script to backup database data to SQL file
# Usage: ./backup-database.sh [backup-name]

BACKUP_NAME=${1:-$(date +%Y%m%d_%H%M%S)}
BACKUP_DIR="/var/www/html/src/db/backups"
BACKUP_FILE="${BACKUP_DIR}/backup_${BACKUP_NAME}.sql"

# Database credentials
DB_HOST="mysql"
DB_NAME="mydatabase"
DB_USER="myuser"
DB_PASS="mypassword"

echo "Creating database backup..."
echo "Backup file: ${BACKUP_FILE}"

# Create backup directory if it doesn't exist
mkdir -p "${BACKUP_DIR}"

# Export database data (structure + data)
mysqldump -h "${DB_HOST}" -u "${DB_USER}" -p"${DB_PASS}" \
    --single-transaction \
    --routines \
    --triggers \
    "${DB_NAME}" > "${BACKUP_FILE}"

if [ $? -eq 0 ]; then
    echo "✓ Backup created successfully: ${BACKUP_FILE}"
    echo "File size: $(du -h "${BACKUP_FILE}" | cut -f1)"
else
    echo "✗ Backup failed!"
    exit 1
fi


