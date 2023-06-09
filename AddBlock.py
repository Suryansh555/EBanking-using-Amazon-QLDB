from pyqldb.config.retry_config import RetryConfig
from pyqldb.driver.qldb_driver import QldbDriver
import sys

# Configure retry limit to 3
retry_config = RetryConfig(retry_limit=3)

# Initialize the driver
print("Initializing the driver")
qldb_driver = QldbDriver("Transactions",region_name="ap-southeast-1", retry_config=retry_config)
for table in qldb_driver.list_tables():
    print(table)

def insert_documents(transaction_executor, arg_1):
    print("Inserting a document")
    transaction_executor.execute_statement("INSERT INTO transaction_final ?", arg_1)

if len(sys.argv) >= 10:
    payee = sys.argv[1]
    reciever = sys.argv[2]
    amount = sys.argv[3]
    commision = sys.argv[4]
    particulars = sys.argv[5]
    transactiontype = sys.argv[6]
    transdatetime = sys.argv[7]
    approval = sys.argv[8]
    status = sys.argv[9]
    doc_1 = { 'Sender_ID': payee,
          'Reciever_ID': reciever,
          'Amount' : amount,
          'Commision' : commision ,
          'Particulars' : particulars ,
          'Transactiontype' : transactiontype ,
          'TransactionDate' : transdatetime,
          'TransactionTime' : approval,
          'Status' : status

        }
    qldb_driver.execute_lambda(lambda x: insert_documents(x, doc_1))
else:
    print("Invalid arguments provided.")