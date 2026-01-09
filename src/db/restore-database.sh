#!/bin/bash
# Script to restore database from SQL backup file
# Usage: ./restore-database.sh <backup-file.sql>

if [ -z "$1" ]; then
    echo "Usage: ./restore-database.sh <backup-file.sql>"
    echo "Available backups:"
    ls -lh /var/www/html/src/db/backups/*.sql 2>/dev/null || echo "No backups found"
    exit 1
fi

BACKUP_FILE="$1"

# Check if file exists
if [ ! -f "${BACKUP_FILE}" ]; then
    echo "Error: Backup file not found: ${BACKUP_FILE}"
    exit 1
fi

# Database credentials
DB_HOST="mysql"
DB_NAME="mydatabase"
DB_USER="myuser"
DB_PASS="mypassword"

echo "WARNING: This will replace all data in the database!"
echo "Backup file: ${BACKUP_FILE}"
read -p "Are you sure you want to continue? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "Restore cancelled."
    exit 0
fi

echo "Restoring database from backup..."

# Restore database
mysql -h "${DB_HOST}" -u "${DB_USER}" -p"${DB_PASS}" "${DB_NAME}" < "${BACKUP_FILE}"

if [ $? -eq 0 ]; then
    echo "✓ Database restored successfully from: ${BACKUP_FILE}"
else
    echo "✗ Restore failed!"
    exit 1
fi


