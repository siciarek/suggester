# language: pl

Potrzeba biznesowa: Sprawdzenie czy aplikacja jest dostępna
  Aby korzystać z aplikacji
  As a Użytkownik
  Chciałbym mieć możliwość sprawdzenia czy aplikacja jest dostępna

  Scenariusz: Sprawdzenie czy działa strona formularza
    Jeżeli odwiedzę stronę "/form"
    Wtedy powinienem być na stronie "/form"
    I kod statusu odpowiedzi powinien być równy 200
    I kod statusu odpowiedzi nie powinien być równy 404

  Scenariusz: Powtórne sprawdzenie czy działa strona listy
    Jeżeli odwiedzę stronę "/"
    Wtedy powinienem być na stronie "/"
    I kod statusu odpowiedzi powinien być równy 200
    I kod statusu odpowiedzi nie powinien być równy 404
