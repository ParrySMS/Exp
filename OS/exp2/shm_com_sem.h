#include <fcntl.h> 
#include <sys/stat.h>
#include <semaphore.h>

#define LINE_SIZE 256
#define NUM_LINE 16

// reconize id
const char *queue_mutex = "queue_mutex";
const char *queue_empty = "queue_empty";
const char *queue_full = "queue_full";	

//buffer 

struct shared_mem_st{
	char buffer[NUM_LINE][LINE_SIZE];
	int line_write;
	int line_read;
};


