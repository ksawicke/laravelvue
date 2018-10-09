<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-title">
        UI Elements
      </li>
      <li class="nav-item">
          <router-link :to="{ name: 'home' }" class="nav-link">Home</router-link>
      </li>
        <li class="nav-item">
            <router-link :to="{ name: 'hello' }" class="nav-link">Hello World</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{ name: 'users.index' }" class="nav-link">Users</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{ name: 'companies.index' }" class="nav-link">Companies</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{ name: 'statuses.index' }" class="nav-link">Statuses</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{ name: 'educationLevels.index' }" class="nav-link">Education Levels</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{ name: 'countries.index' }" class="nav-link">Countries</router-link>
        </li>
        <li class="nav-item">
            <router-link :to="{ name: 'subdivisionTypes.index' }" class="nav-link">Country Subdivisions</router-link>
        </li>
    </ul>
  </nav>
  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
