import csv
rows = []
with open('ratings.csv', encoding = 'cp850') as csv_file:
    csvreader = csv.reader(csv_file, delimiter=',')
    header = next(csvreader)
    for row in csvreader:
        rows.append(row)
print(len(rows))