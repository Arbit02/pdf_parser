import pdfplumber
import json

data = []

with pdfplumber.open("file.pdf") as pdf:
    for page_number, page in enumerate(pdf.pages):
        table = page.extract_table()
        if table:
            headers = table[0]
            for row in table[1:]:
                entry = {headers[i]: row[i] for i in range(len(headers))}
                data.append(entry)

with open("data.json", "w", encoding="utf-8") as json_file:
    json.dump(data, json_file, ensure_ascii=False, indent=4)
print(2)
