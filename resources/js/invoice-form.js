const form = document.querySelector('[data-invoice-form]');
if (form) {
    const container = form.querySelector('[data-items]');
    const addButton = form.querySelector('[data-add-item]');
    const template = document.querySelector('#item-template');
    const message = form.querySelector('[data-item-message]');
    const taxInput = form.querySelector('#tax_percentage');
    let nextIndex = Math.max(0, ...Array.from(container.querySelectorAll('input[name]'), (input) => Number(input.name.match(/items\[(\d+)\]/)?.[1] ?? 0))) + 1;
    const rupiah = (value) => `Rp ${value.toLocaleString('id-ID')}`;
    const integer = (value) => /^\d{1,12}$/.test(value) ? BigInt(value) : 0n;

    function calculate() {
        let subtotal = 0n;
        const rows = container.querySelectorAll('[data-item-row]');
        rows.forEach((row) => {
            const total = integer(row.querySelector('[data-quantity]').value) * integer(row.querySelector('[data-price]').value);
            subtotal += total;
            row.querySelector('[data-line-total]').textContent = rupiah(total);
            row.querySelector('[data-remove-item]').disabled = rows.length <= 1;
        });
        const [whole, fraction = ''] = (taxInput.value || '0').split('.');
        const basisPoints = integer(whole) * 100n + integer(fraction.padEnd(2, '0').slice(0, 2));
        const tax = (subtotal * basisPoints + 5000n) / 10000n;
        form.querySelector('[data-subtotal]').textContent = rupiah(subtotal);
        form.querySelector('[data-tax]').textContent = rupiah(tax);
        form.querySelector('[data-total]').textContent = rupiah(subtotal + tax);
        form.querySelector('[data-tax-label]').textContent = `(${(taxInput.value || '0').replace('.', ',')}%)`;
        addButton.disabled = rows.length >= 100;
    }

    addButton.addEventListener('click', () => {
        if (container.querySelectorAll('[data-item-row]').length >= 100) return;
        const fragment = template.content.cloneNode(true);
        fragment.querySelectorAll('[name], [id], [for], [aria-label]').forEach((element) => {
            for (const attribute of ['name', 'id', 'for', 'aria-label']) {
                if (element.hasAttribute(attribute)) element.setAttribute(attribute, element.getAttribute(attribute).replaceAll('__INDEX__', nextIndex).replaceAll('__NUMBER__', nextIndex + 1));
            }
        });
        nextIndex += 1;
        const row = fragment.querySelector('[data-item-row]');
        container.append(fragment);
        document.dispatchEvent(new CustomEvent('invoice:item-added', { detail: row }));
        row.querySelector('input').focus();
        message.textContent = `${container.children.length} item ditambahkan. Maksimal 100 item per invoice.`;
        calculate();
    });

    container.addEventListener('click', (event) => {
        const button = event.target.closest('[data-remove-item]');
        if (!button || container.querySelectorAll('[data-item-row]').length <= 1) return;
        button.closest('[data-item-row]').remove();
        message.textContent = `Item dihapus. Tersisa ${container.children.length} item.`;
        addButton.focus();
        calculate();
    });
    form.addEventListener('input', calculate);
    const invoiceDate = form.querySelector('#invoice_date');
    const dueDate = form.querySelector('#due_date');
    function setDueDateMinimum() { dueDate.min = invoiceDate.value; }
    invoiceDate.addEventListener('change', setDueDateMinimum);
    setDueDateMinimum();
    calculate();
}
