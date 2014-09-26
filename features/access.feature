# language: pl

@access @form
Potrzeba biznesowa: Zapewnienie uprawnionym użytkownikom dostępu do odpowiednich stron aplikacji
  Aby zapewnić dostęp do odpowiednich stron tylko uprawnionym użytkownikom
  As a Właściciel aplikacji
  Chciałbym mieć pewność, że tylko uprawnieni użytkownicy mają do nich dostęp

  Założenia: Użytkownik powinien być wylogowany a strona powinna być w języku polskim i w trybie produkcyjnym
    Zakładając że aplikacja jest w środowisku produkcyjnym
    I że odwiedzę stronę "/sign-out"
    Oraz odwiedzę stronę "/locale/pl"

  Scenariusz: Próba otwarcia nieistniejącej strony
    Zakładając że odwiedzę stronę "/not/existing/page"
    Wtedy powinienem być na stronie "/not/existing/page"
    Wtedy element "h2.headline.text-info" powinien zawierać "404"
    I kod statusu odpowiedzi powinien być równy 404

  Scenariusz: Próba otwarcia strony, na której wystąpił błąd systemowy
    Zakładając że odwiedzę stronę "/test/exception"
    Wtedy powinienem być na stronie "/test/exception"
    Wtedy element "h2.headline.text-info" powinien zawierać "500"
    I kod statusu odpowiedzi powinien być równy 500

  Scenariusz: Próba dostępu do niezabezpieczonej strony
    Zakładając że odwiedzę stronę "/test/guest"
    Wtedy powinienem być na stronie "/test/guest"
    I kod statusu odpowiedzi powinien być równy 200
    Wtedy zobaczę tekst "Guest"
    I kod statusu odpowiedzi powinien być równy 200

  Scenariusz: Próba dostępu do zabezpieczonej strony przez zarejestrowanego użytkownika
    Zakładając że odwiedzę stronę "/test/user"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 403
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "czesolak"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/test/user"
    Wtedy zobaczę tekst "User"
    I kod statusu odpowiedzi powinien być równy 200

  Scenariusz: Próba dostępu do zabezpieczonej strony przez niezarejestrowanego użytkownika
    Zakładając że odwiedzę stronę "/test/user"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 403
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "nieistniejący"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/sign-in"
    Wtedy element "div.alert.alert-warning" powinien zawierać "Niewłaściwe dane dostępowe."
    I kod statusu odpowiedzi powinien być równy 403

  Scenariusz: Próba dostępu do zabezpieczonej strony przez użytkownika z wyłączonym kontem
    Zakładając że odwiedzę stronę "/test/user"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 403
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "pcichacki"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/sign-in"
    Wtedy element "div.alert.alert-warning" powinien zawierać "Konto zostało zablokowane, skontaktuj się z administratorem."
    I kod statusu odpowiedzi powinien być równy 403

  Scenariusz: Próba dostępu do zabezpieczonej strony przez administratora
    Zakładając że odwiedzę stronę "/test/admin"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 403
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "mariolak"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/test/admin"
    Wtedy zobaczę tekst "Admin"
    I kod statusu odpowiedzi powinien być równy 200

  Scenariusz: Próba dostępu do zabezpieczonej strony przez użytkownika z nieodpowiednimi uprawnieniami
    Zakładając że odwiedzę stronę "/test/user"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 403
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "czesolak"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/test/user"
    Wtedy zobaczę tekst "User"
    I kod statusu odpowiedzi powinien być równy 200
    Jeżeli odwiedzę stronę "/test/admin"
    Wtedy element "h2.headline.text-info" powinien zawierać "403"
    I kod statusu odpowiedzi powinien być równy 403

  Scenariusz: Sprawdzenie poprawnego wylogowania
    Zakładając że odwiedzę stronę "/test/user"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 403
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "czesolak"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/test/user"
    Wtedy zobaczę tekst "User"
    I kod statusu odpowiedzi powinien być równy 200
    Jeżeli odwiedzę stronę "/sign-out"
    Wtedy powinienem być na stronie "/"
    Jeżeli odwiedzę stronę "/test/user"
    Wtedy powinienem być na stronie "/sign-in"
    I kod statusu odpowiedzi powinien być równy 403

  Scenariusz: Próba zalogowania bezpośrednio przez stronę logowania
    Zakładając że odwiedzę stronę "/sign-in"
    Wtedy kod statusu odpowiedzi powinien być równy 200
    Wtedy element "h1.page-header" powinien zawierać "Zaloguj się"
    Jeżeli wypełnię pole "username" wartością "czesolak"
    I wypełnię pole "password" wartością "password"
    I nacisnę przycisk "Zaloguj się"
    Wtedy powinienem być na stronie "/"
