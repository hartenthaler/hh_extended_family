#!/bin/bash
# I18N - Update PO-/POT-files from source code
SCRIPTDIR=$(dirname "$(realpath -s "${BASH_SOURCE:-$0}")")

PROJECT_ROOT=$(realpath "${SCRIPTDIR}/..")
LANG_DIR="$PROJECT_ROOT/resources/lang"
POT_FILE="$LANG_DIR/messages.pot"

cd "$PROJECT_ROOT" || exit 1

echo "📦 Generate POT-File: $POT_FILE"

# create template file
xgettext -L PHP \
  --keyword=translate \
  --keyword=plural:1,2 \
  --from-code=utf-8 \
  --output="$POT_FILE" \
  $(find . -not -path "./util/*" \( -name "*.php" -o -name "*.phtml" \))

echo "✅ POT-file created."

#exit 0 # if using Weblate for managing translations

## po files are updated via Weblate to prevent conflicts
# init PO-files
for PO_FILE in "$LANG_DIR"/*.po; do
  lang=$(basename "${PO_FILE%.*}")

  if [[ -f "$PO_FILE" ]]; then
    echo "🔄 Update existing PO-file for [$lang]"
    msgmerge --update --backup=none "$PO_FILE" "$POT_FILE"
  else
    echo "🆕 Create new PO-file for [$lang]"
    msginit --input="$POT_FILE" --locale="$lang" --output-file="$PO_FILE" --no-translator
  fi
done

echo "✅ All language files are up to date."
exit 0