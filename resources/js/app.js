document.addEventListener('DOMContentLoaded', () => {
  initDesiredSchools();
  initTeacherAssignments();

  const toggle = document.querySelector('[data-menu-toggle]');
  const header = document.querySelector('.app-header');
  const srText = toggle?.querySelector('.sr-only');

  if (!toggle || !header) return;

  toggle.addEventListener('click', () => {
    const isOpen = header.classList.toggle('is-menu-open');
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

    if (srText) {
      srText.textContent = isOpen ? 'メニューを閉じる' : 'メニューを開く';
    }
  });
});

function initDesiredSchools() {
  const list = document.getElementById('desired-schools-list');
  const addButton = document.getElementById('add-school-button');

  if (!list || !addButton) return;

  addButton.addEventListener('click', () => {
    const row = document.createElement('div');
    row.className = 'desired-school-row';

    row.innerHTML = `
      <input type="text" name="desired_schools[]" value="" placeholder="志望校" class="form-input">
      <button type="button" class="remove-school-button">削除</button>
    `;

    list.appendChild(row);
  });

  list.addEventListener('click', (event) => {
    const target = event.target;
    if (!(target instanceof HTMLElement)) return;

    if (target.classList.contains('remove-school-button')) {
      const row = target.closest('.desired-school-row');
      if (row) row.remove();
    }
  });
}

function initTeacherAssignments() {
  const list = document.getElementById('teacher-assignment-list');
  const addButton = document.getElementById('add-teacher-assignment-button');
  const teacherOptionsSource = document.getElementById('teacher-options-data');
  const subjectOptionsSource = document.getElementById('subject-options-data');

  if (!list || !addButton || !teacherOptionsSource || !subjectOptionsSource) return;

  const teacherOptions = JSON.parse(teacherOptionsSource.textContent || '[]');
  const subjectOptions = JSON.parse(subjectOptionsSource.textContent || '[]');

  addButton.addEventListener('click', () => {
    const index = getNextTeacherAssignmentIndex(list);

    const teacherOptionsHtml = [
      '<option value="">選択してください</option>',
      ...teacherOptions.map((teacher) => {
        return `<option value="${escapeHtml(String(teacher.id))}">${escapeHtml(teacher.name)}</option>`;
      }),
    ].join('');

    const subjectOptionsHtml = subjectOptions.map((subject) => {
      const escaped = escapeHtml(subject);
      return `
        <label class="ui-checkbox-tile">
          <input type="checkbox" name="teacher_assignments[${index}][subjects][]" value="${escaped}">
          <span>${escaped}</span>
        </label>
      `;
    }).join('');

    const card = document.createElement('div');
    card.className = 'teacher-assignment-card';

    card.innerHTML = `
      <div class="ui-item-card teacher-assignment-card">
        <div class="ui-item-card-header">
          <span class="ui-item-card-title">担当講師${index + 1}</span>
          <button type="button" class="table-button table-button-danger remove-assignment-button">
            この担当を削除
          </button>
        </div>

        <div class="ui-form-grid">
          <div class="ui-form-field">
            <label class="form-label">講師</label>
            <select name="teacher_assignments[${index}][teacher_id]" class="form-input">
              ${teacherOptionsHtml}
            </select>
          </div>

          <div class="ui-form-field ui-form-field--full">
            <label class="form-label">担当科目</label>
            <div class="ui-selection-panel">
              <div class="ui-checkbox-grid">
                ${subjectOptionsHtml}
              </div>
            </div>
          </div>
        </div>
      </div>
    `;

    list.appendChild(card);
  });

  list.addEventListener('click', (event) => {
    const target = event.target;
    if (!(target instanceof HTMLElement)) return;

    if (target.classList.contains('remove-assignment-button')) {
      const card = target.closest('.teacher-assignment-card');
      if (card) card.remove();
    }
  });
}

function getNextTeacherAssignmentIndex(list) {
  const names = Array.from(
    list.querySelectorAll('select[name^="teacher_assignments["], input[name^="teacher_assignments["]')
  ).map((element) => element.getAttribute('name') || '');

  const indexes = names
    .map((name) => {
      const match = name.match(/^teacher_assignments\[(\d+)\]/);
      return match ? Number(match[1]) : null;
    })
    .filter((index) => Number.isInteger(index));

  if (indexes.length === 0) return 0;

  return Math.max(...indexes) + 1;
}

function escapeHtml(value) {
  return value
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&#039;');
}