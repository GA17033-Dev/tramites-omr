export function toCsv<T extends Record<string, unknown>>(
  rows: T[],
  columns: { key: keyof T; label: string; format?: (row: T) => string }[],
  sep = ';',
): string {
  const escape = (v: string) => {
    const s = v.replace(/"/g, '""');
    return v.includes('"') || v.includes('\n') || v.includes(sep) ? `"${s}"` : s;
  };

  const header = columns.map((c) => escape(c.label)).join(sep);
  const body = rows
    .map((row) =>
      columns
        .map((c) => escape(c.format ? c.format(row) : String(row[c.key] ?? '')))
        .join(sep),
    )
    .join('\r\n');

  return '\uFEFF' + header + '\r\n' + body;
}

export function downloadCsv(filename: string, csv: string): void {
  const url = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8;' }));
  const a = Object.assign(document.createElement('a'), {
    href: url,
    download: filename.endsWith('.csv') ? filename : `${filename}.csv`,
  });
  document.body.appendChild(a);
  a.click();
  a.remove();
  URL.revokeObjectURL(url);
}