# Projekt na potrzeby rekruatacji

## Pobranie kodu

Pobierz kod za pomocą git clone:

```sh
git clone git@github.com:kamildlugolecki19998/rekrutacja-cssa.git
```

## Setup

Przejdz do katalogu projektu i zbuduj projekt za pomocą skryptu setup.sh

```sh
cd rekrutacja-cssa
./ setup.sh
```

## Testowanie

### [Aby przetestować działanie aplikacji przejdz na adres](localhost/api/doc/)

#### Projekt zawiera natępujące endpinty 

#### Uzyskanie tokenu do autoryzacji
[localhost/api/login](localhost/api/login)

#### Dokonanie kalkulacji
[/api/repayment_schedule](/api/repayment_schedule)

#### Wylaczenie poszczególnej kalkulacji
[/api/repayment_schedule/{id}/exclude](/api/repayment_schedule/{id}/exclude)

#### Wylistowanie 4 ostatnich kalkulacji
[/api/repayment_schedules](/api/repayment_schedules)

### Aby z autoryzować się za pomocą tokenu uzyskany token nalezy wkleić do formularza który pokaze się po naciścięcu przyciku authorize a następnie zatwierdzić przyciskiem Authorize