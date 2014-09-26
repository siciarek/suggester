# language: pl

@form @suggestion
Potrzeba biznesowa: Możliwość dodawania sugestii i opinii przez użytkowników
  Aby ulepszać i poprawiać funkcjonalność aplikacji
  As a Użytkownik
  Chciałbym mieć możliwość rejestrowania swoich uwag na temat aplikacji

  Założenia: Strona powinna być po polsku
    I odwiedzę stronę "/locale/pl"

  @simple
  Scenariusz: Dodanie nowej opini z domyślnymi wartościami formularza
    Zakładając że w systemie nie ma testowych danych
    I odwiedzę stronę "/"
    I zobaczę tekst "Lista sugestii (0)"
    I zobaczę tekst "Lista jest pusta."
    Zakładając że odwiedzę stronę "/"
    I nie zobaczę tekstu "Sugestia dodana z domyślnymi ustawieniami formularza."
    Jeżeli odwiedzę stronę "/form?application=Suggester"
    I wybiorę opcję "Komentarz" w polu "type_id"
    I wypełnię pole "content" wartością "Sugestia dodana z domyślnymi ustawieniami formularza."
    I wypełnię ukryte pole "author" wartością "Acceptance Test"
    I nacisnę przycisk "Zapisz"
    Wtedy powinienem być na stronie "/prompt"
    I kod statusu odpowiedzi powinien być równy 200
    Ale kod statusu odpowiedzi nie powinien być równy 404
    Jeżeli odwiedzę stronę "/"
    Wtedy zobaczę tekst "Lista sugestii (1)"
    I zobaczę tekst "Sugestia dodana z domyślnymi ustawieniami formularza."
    Zakładając że w systemie nie ma testowych danych

  @multi
  Szablon scenariusza: Dodanie nowych opini z wybranymi wartościami formularza
    Zakładając że odwiedzę stronę "/"
    I nie zobaczę tekstu "<sugestia>"
    Jeżeli odwiedzę stronę "/form?application=Suggester"
    I wypełnię pole "content" wartością "<sugestia>"
    I wybiorę opcję "<typ>" w polu "type_id"
    I wybiorę opcję "<priorytet>" w polu "priority"
    I wypełnię ukryte pole "author" wartością "Acceptance Test"
    I nacisnę przycisk "Zapisz"
    Wtedy powinienem być na stronie "/prompt"
    I kod statusu odpowiedzi powinien być równy 200
    Ale kod statusu odpowiedzi nie powinien być równy 404
    Jeżeli odwiedzę stronę "/"
    Wtedy zobaczę tekst "Lista sugestii (<liczba>)"
    I zobaczę tekst "<sugestia>"

    Przykłady:
      | typ                                | priorytet | sugestia   | liczba |

      | Usterka                            | M         | Opinia 1 M | 1    |
      | Dodanie nowej funkcjonalności      | M         | Opinia 2 M | 2    |
      | Zmiana istniejącej funkcjonalności | M         | Opinia 3 M | 3    |
      | Komentarz                          | M         | Opinia 4 M | 4    |
      | Inna sugestia                      | M         | Opinia 5 M | 5    |

      | Usterka                            | S         | Opinia 1 S | 6    |
      | Dodanie nowej funkcjonalności      | S         | Opinia 2 S | 7    |
      | Zmiana istniejącej funkcjonalności | S         | Opinia 3 S | 8    |
      | Komentarz                          | S         | Opinia 4 S | 9    |
      | Inna sugestia                      | S         | Opinia 5 S | 10   |

      | Usterka                            | C         | Opinia 1 C | 11   |
      | Dodanie nowej funkcjonalności      | C         | Opinia 2 C | 12   |
      | Zmiana istniejącej funkcjonalności | C         | Opinia 3 C | 13   |
      | Komentarz                          | C         | Opinia 4 C | 14   |
      | Inna sugestia                      | C         | Opinia 5 C | 15   |

      | Usterka                            | W         | Opinia 1 W | 16   |
      | Dodanie nowej funkcjonalności      | W         | Opinia 2 W | 17   |
      | Zmiana istniejącej funkcjonalności | W         | Opinia 3 W | 18   |
      | Komentarz                          | W         | Opinia 4 W | 19   |
      | Inna sugestia                      | W         | Opinia 5 W | 20   |
