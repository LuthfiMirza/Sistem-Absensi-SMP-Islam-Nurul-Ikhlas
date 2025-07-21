# 🤝 Contributing Guidelines

Terima kasih atas minat Anda untuk berkontribusi pada Sistem Absensi SMP Islam Nurul Ikhlas! Panduan ini akan membantu Anda memahami cara berkontribusi dengan efektif.

## 📋 Daftar Isi

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Process](#development-process)
- [Coding Standards](#coding-standards)
- [Testing Guidelines](#testing-guidelines)
- [Pull Request Process](#pull-request-process)
- [Issue Guidelines](#issue-guidelines)

---

## 📜 Code of Conduct

### Our Pledge
Kami berkomitmen untuk menciptakan lingkungan yang terbuka dan ramah bagi semua kontributor, tanpa memandang:
- Usia, ukuran tubuh, disabilitas
- Etnis, identitas gender, tingkat pengalaman
- Kebangsaan, penampilan pribadi, ras, agama
- Orientasi seksual dan identitas

### Our Standards
**Perilaku yang diharapkan:**
- ✅ Menggunakan bahasa yang ramah dan inklusif
- ✅ Menghormati sudut pandang dan pengalaman yang berbeda
- ✅ Menerima kritik konstruktif dengan baik
- ✅ Fokus pada yang terbaik untuk komunitas
- ✅ Menunjukkan empati terhadap anggota komunitas lain

**Perilaku yang tidak dapat diterima:**
- ❌ Penggunaan bahasa atau gambar yang bersifat seksual
- ❌ Trolling, komentar yang menghina atau menyerang
- ❌ Pelecehan publik atau pribadi
- ❌ Mempublikasikan informasi pribadi orang lain tanpa izin
- ❌ Perilaku lain yang tidak pantas dalam lingkungan profesional

---

## 🚀 Getting Started

### Prerequisites
Pastikan Anda telah menginstall:
- PHP 8.1+
- Composer 2.0+
- Node.js 16.0+
- MySQL 8.0+
- Git

### Fork & Clone
```bash
# 1. Fork repository di GitHub
# 2. Clone fork Anda
git clone https://github.com/YOUR_USERNAME/Sistem-Absensi-SMP-Islam-Nurul-Ikhlas.git
cd Sistem-Absensi-SMP-Islam-Nurul-Ikhlas

# 3. Add upstream remote
git remote add upstream https://github.com/LuthfiMirza/Sistem-Absensi-SMP-Islam-Nurul-Ikhlas.git

# 4. Install dependencies
composer install
npm install
```

### Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Setup database
php artisan migrate --seed

# Build assets
npm run dev
```

---

## 🔄 Development Process

### Workflow
1. **Create Issue** - Diskusikan fitur/bug sebelum coding
2. **Create Branch** - Buat branch dari `main`
3. **Develop** - Koding dengan mengikuti standards
4. **Test** - Pastikan semua test pass
5. **Commit** - Commit dengan pesan yang jelas
6. **Push** - Push ke fork Anda
7. **Pull Request** - Buat PR ke repository utama

### Branch Naming Convention
```bash
# Feature branches
feature/user-authentication
feature/qr-code-scanner
feature/attendance-report

# Bug fix branches
bugfix/login-validation
bugfix/qr-scanner-camera

# Hotfix branches
hotfix/security-patch
hotfix/critical-bug

# Documentation branches
docs/api-documentation
docs/installation-guide
```

### Commit Message Format
```
type(scope): subject

body

footer
```

**Types:**
- `feat`: Fitur baru
- `fix`: Bug fix
- `docs`: Dokumentasi
- `style`: Formatting, missing semi colons, etc
- `refactor`: Code refactoring
- `test`: Adding tests
- `chore`: Maintenance tasks

**Examples:**
```bash
feat(auth): add two-factor authentication

- Implement TOTP-based 2FA
- Add QR code generation for setup
- Include backup codes functionality

Closes #123

fix(qr): resolve camera permission issue on iOS

The QR scanner was not requesting camera permission properly on iOS devices.
This fix ensures proper permission handling across all mobile browsers.

Fixes #456

docs(readme): update installation instructions

- Add Windows-specific setup steps
- Include troubleshooting section
- Update dependency versions
```

---

## 📝 Coding Standards

### PHP Standards (PSR-12)
```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): Response
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(15);

        return response()->view('users.index', compact('users'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): Response
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'data' => $user,
        ], 201);
    }
}
```

### JavaScript Standards (ES6+)
```javascript
// Use const/let instead of var
const API_BASE_URL = '/api/v1';
let currentUser = null;

// Use arrow functions
const fetchUsers = async (page = 1) => {
    try {
        const response = await fetch(`${API_BASE_URL}/users?page=${page}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching users:', error);
        throw error;
    }
};

// Use template literals
const generateUserCard = (user) => {
    return `
        <div class="user-card" data-user-id="${user.id}">
            <h3>${user.name}</h3>
            <p>${user.email}</p>
            <span class="badge ${user.is_active ? 'active' : 'inactive'}">
                ${user.is_active ? 'Active' : 'Inactive'}
            </span>
        </div>
    `;
};

// Use destructuring
const { name, email, role } = user;

// Use modules
export { fetchUsers, generateUserCard };
```

### Blade Templates
```blade
{{-- Use semantic HTML --}}
<article class="attendance-card">
    <header class="card-header">
        <h2 class="card-title">{{ $attendance->title }}</h2>
        <time datetime="{{ $attendance->created_at->toISOString() }}">
            {{ $attendance->created_at->format('d/m/Y') }}
        </time>
    </header>
    
    <main class="card-body">
        <p class="card-description">{{ $attendance->description }}</p>
        
        @if($attendance->is_active)
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle" aria-hidden="true"></i>
                Absensi sedang aktif
            </div>
        @endif
    </main>
    
    <footer class="card-footer">
        <a href="{{ route('attendances.show', $attendance) }}" 
           class="btn btn-primary"
           aria-label="Lihat detail {{ $attendance->title }}">
            Lihat Detail
        </a>
    </footer>
</article>
```

### CSS/SCSS Standards
```scss
// Use BEM methodology
.attendance-card {
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease;

    &:hover {
        transform: translateY(-2px);
    }

    &__header {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    &__title {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
    }

    &__body {
        padding: 1rem;
    }

    &__description {
        color: #718096;
        line-height: 1.5;
    }

    &--active {
        border-left: 4px solid #48bb78;
    }

    &--inactive {
        opacity: 0.6;
    }
}

// Use CSS custom properties
:root {
    --primary-color: #4e73df;
    --success-color: #1cc88a;
    --warning-color: #f6c23e;
    --danger-color: #e74a3b;
    --font-family: 'Inter', sans-serif;
}
```

---

## 🧪 Testing Guidelines

### Unit Tests
```php
<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Attendance;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_attendance()
    {
        $attendanceData = [
            'title' => 'Daily Attendance',
            'description' => 'Regular daily attendance',
            'start_time' => '07:00:00',
            'end_time' => '16:00:00',
        ];

        $attendance = Attendance::create($attendanceData);

        $this->assertInstanceOf(Attendance::class, $attendance);
        $this->assertEquals('Daily Attendance', $attendance->title);
        $this->assertDatabaseHas('attendances', $attendanceData);
    }

    /** @test */
    public function it_belongs_to_many_positions()
    {
        $attendance = Attendance::factory()->create();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $attendance->positions()
        );
    }
}
```

### Feature Tests
```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest();
    }
}
```

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AuthenticationTest.php

# Run with coverage
php artisan test --coverage

# Run tests in parallel
php artisan test --parallel
```

---

## 🔄 Pull Request Process

### Before Creating PR
1. **Sync with upstream**
   ```bash
   git fetch upstream
   git checkout main
   git merge upstream/main
   ```

2. **Rebase your branch**
   ```bash
   git checkout your-feature-branch
   git rebase main
   ```

3. **Run tests**
   ```bash
   php artisan test
   npm run test
   ```

4. **Check code style**
   ```bash
   composer run-script cs-check
   npm run lint
   ```

### PR Template
```markdown
## Description
Brief description of changes made.

## Type of Change
- [ ] Bug fix (non-breaking change which fixes an issue)
- [ ] New feature (non-breaking change which adds functionality)
- [ ] Breaking change (fix or feature that would cause existing functionality to not work as expected)
- [ ] Documentation update

## Testing
- [ ] Unit tests pass
- [ ] Feature tests pass
- [ ] Manual testing completed

## Screenshots (if applicable)
Add screenshots to help explain your changes.

## Checklist
- [ ] My code follows the style guidelines of this project
- [ ] I have performed a self-review of my own code
- [ ] I have commented my code, particularly in hard-to-understand areas
- [ ] I have made corresponding changes to the documentation
- [ ] My changes generate no new warnings
- [ ] I have added tests that prove my fix is effective or that my feature works
- [ ] New and existing unit tests pass locally with my changes

## Related Issues
Closes #123
Fixes #456
```

### Review Process
1. **Automated Checks** - CI/CD pipeline runs automatically
2. **Code Review** - At least one maintainer reviews
3. **Testing** - Reviewer tests functionality
4. **Approval** - PR gets approved
5. **Merge** - Maintainer merges to main branch

---

## 🐛 Issue Guidelines

### Bug Reports
```markdown
**Bug Description**
A clear and concise description of what the bug is.

**To Reproduce**
Steps to reproduce the behavior:
1. Go to '...'
2. Click on '....'
3. Scroll down to '....'
4. See error

**Expected Behavior**
A clear and concise description of what you expected to happen.

**Screenshots**
If applicable, add screenshots to help explain your problem.

**Environment:**
- OS: [e.g. Windows 10, Ubuntu 20.04]
- Browser: [e.g. Chrome 91, Firefox 89]
- PHP Version: [e.g. 8.1.2]
- Laravel Version: [e.g. 10.0]

**Additional Context**
Add any other context about the problem here.
```

### Feature Requests
```markdown
**Is your feature request related to a problem?**
A clear and concise description of what the problem is.

**Describe the solution you'd like**
A clear and concise description of what you want to happen.

**Describe alternatives you've considered**
A clear and concise description of any alternative solutions or features you've considered.

**Additional context**
Add any other context or screenshots about the feature request here.
```

### Labels
- `bug` - Something isn't working
- `enhancement` - New feature or request
- `documentation` - Improvements or additions to documentation
- `good first issue` - Good for newcomers
- `help wanted` - Extra attention is needed
- `question` - Further information is requested

---

## 🏆 Recognition

### Contributors
Semua kontributor akan diakui dalam:
- README.md file
- CONTRIBUTORS.md file
- Release notes
- GitHub contributors page

### Contribution Types
Kami menghargai semua jenis kontribusi:
- 💻 Code contributions
- 📖 Documentation improvements
- 🐛 Bug reports
- 💡 Feature suggestions
- 🎨 Design improvements
- 🌍 Translations
- 📢 Community support

---

## 📞 Getting Help

Jika Anda membutuhkan bantuan:

1. **Documentation** - Baca dokumentasi lengkap
2. **Issues** - Search existing issues
3. **Discussions** - Join GitHub Discussions
4. **Email** - Contact maintainers

---

**Terima kasih telah berkontribusi! 🙏**

Setiap kontribusi, sekecil apapun, sangat berarti bagi pengembangan sistem ini.