#!/bin/bash
# Script to backup database from host machine
# Usage: ./backup-from-host.sh [backup-name]

BACKUP_NAME=${1:-$(date +%Y%m%d_%H%M%S)}
BACKUP_DIR="db/backups"
BACKUP_FILE="${BACKUP_DIR}/backup_${BACKUP_NAME}.sql"

echo "Creating database backup from host..."
echo "Backup file: ${BACKUP_FILE}"

# Create backup directory if it doesn't exist
mkdir -p "${BACKUP_DIR}"

# Export database data (structure + data) from host
docker exec mysql-db mysqldump -u myuser -pmypassword \
    --single-transaction \
    --routines \
    --triggers \
    mydatabase > "${BACKUP_FILE}"

if [ $? -eq 0 ]; then
    echo "✓ Backup created successfully: ${BACKUP_FILE}"
    echo "File size: $(du -h "${BACKUP_FILE}" | cut -f1)"
    echo ""
    echo "To commit to git:"
    echo "  git add ${BACKUP_FILE}"
    echo "  git commit -m 'Database backup ${BACKUP_NAME}'"
else
    echo "✗ Backup failed!"
    exit 1
fi

