/* ========================================
   API
======================================== */

const api = {

  baseUrl:
    window.wpApiSettings?.root ||
    '/wp-json/wp/v2/',

  nonce:
    window.wpApiSettings?.nonce || '',

  cache: new Map(),

  /* ========================================
     GET
  ======================================== */

  async get(endpoint, params = {}) {

    const url =
      new URL(
        this.baseUrl + endpoint
      );

    Object.entries(params)
      .forEach(([key, value]) => {
        url.searchParams.append(
          key,
          value
        );
      });

    const response = await fetch(url, {

      method: 'GET',

      headers: {
        'Content-Type':
          'application/json',

        'X-WP-Nonce':
          this.nonce
      }

    });

    if (!response.ok) {
      throw new Error(
        `API Error: ${response.status}`
      );
    }

    return response.json();

  },

  /* ========================================
     POST
  ======================================== */

  async post(endpoint, data = {}) {

    const response = await fetch(
      this.baseUrl + endpoint,
      {

        method: 'POST',

        headers: {
          'Content-Type':
            'application/json',

          'X-WP-Nonce':
            this.nonce
        },

        body:
          JSON.stringify(data)

      }
    );

    if (!response.ok) {
      throw new Error(
        `API Error: ${response.status}`
      );
    }

    return response.json();

  },

  /* ========================================
     POSTS
  ======================================== */

  getPosts(
    postType = 'posts',
    params = {}
  ) {

    return this.get(postType, {

      per_page: 10,

      _embed: true,

      ...params

    });

  },

  /* ========================================
     SINGLE POST
  ======================================== */

  getPost(
    postType,
    id,
    params = {}
  ) {

    return this.get(
      `${postType}/${id}`,
      {
        _embed: true,
        ...params
      }
    );

  },

  /* ========================================
     SEARCH
  ======================================== */

  searchPosts(
    keyword,
    postType = 'posts',
    params = {}
  ) {

    return this.get(postType, {

      search: keyword,

      ...params

    });

  },

  /* ========================================
     CACHE
  ======================================== */

  getCached(key) {

    const cached =
      this.cache.get(key);

    if (!cached) return null;

    const isExpired =
      Date.now() - cached.timestamp
      > cached.ttl;

    if (isExpired) {

      this.cache.delete(key);

      return null;

    }

    return cached.data;

  },

  setCache(
    key,
    data,
    ttl = 300000
  ) {

    this.cache.set(key, {
      data,
      ttl,
      timestamp: Date.now()
    });

  }

};

window.api = api;