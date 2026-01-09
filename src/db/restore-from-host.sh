#!/bin/bash
# Script to restore database from host machine
# Usage: ./restore-from-host.sh <backup-file.sql>

if [ -z "$1" ]; then
    echo "Usage: ./restore-from-host.sh <backup-file.sql>"
    echo "Available backups:"
    ls -lh db/backups/*.sql 2>/dev/null || echo "No backups found"
    exit 1
fi

BACKUP_FILE="$1"

# Check if file exists
if [ ! -f "${BACKUP_FILE}" ]; then
    echo "Error: Backup file not found: ${BACKUP_FILE}"
    exit 1
fi

echo "WARNING: This will replace all data in the database!"
echo "Backup file: ${BACKUP_FILE}"
read -p "Are you sure you want to continue? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "Restore cancelled."
    exit 0
fi

echo "Restoring database from backup..."

# Restore database from host
docker exec -i mysql-db mysql -u myuser -pmypassword mydatabase < "${BACKUP_FILE}"

if [ $? -eq 0 ]; then
    echo "✓ Database restored successfully from: ${BACKUP_FILE}"
else
    echo "✗ Restore failed!"
    exit 1
fi

