import os
import re

# Regex de emojis en una sola linea (raw string)
emoji_pattern = re.compile(r"[\U0001F600-\U0001F64F\U0001F300-\U0001F5FF\U0001F680-\U0001F6FF\U0001F900-\U0001F9FF\U00002600-\U000026FF\U00002700-\U000027BF]+", re.UNICODE)

def clean_file(filepath):
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
        new_content = emoji_pattern.sub('', content)
        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print("Limpiado: " + filepath)
    except Exception as e:
        print("Error: " + str(e))

# Buscar en carpetas clave
for root, dirs, files in os.walk('.'):
    # Ignorar carpetas de terceros
    if 'vendor' in root or 'node_modules' in root:
        continue
    for file in files:
        if file.endswith(('.php', '.blade.php', '.css', '.js', '.json')):
            clean_file(os.path.join(root, file))

print("Limpieza completada.")
