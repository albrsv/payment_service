# APP

This payment service provides **Purchase**, **Payout**, and **Refund** transactions through external payment providers.

## DB

It is assumed that a single *Payments* table will be used for all operations. 
The table has a **primary key** (*payment_id*) and an **indexed** *project_id* column, which are used for transaction searches.