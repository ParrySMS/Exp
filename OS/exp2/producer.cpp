#include <unistd.h>
#include <stdlib.h>
#include <stdio.h>
#include <string.h>

#include <sys/ipc.h>
#include <sys/shm.h>
#include "./shm_com_sem.h"

/* run this program using the console pauser or add your own getch, system("pause") or input loop */

int main(void) {

	void *shared_memory = (void *)0;
	struct shared_mem_st* shared_stuff;

	char key_line[256] ;
	int shm_id;
	sem_t *sem_queue, *sem_queue_empty, *sem_queue_full;
	//todo:get share memory ,put in
	if ((shm_id=shmget(IPC_PRIVATE, 1024, 0666)) == -1) {
		perror("shmget");
		exit(-1);
	}

	shared_memory = shmat(shm_id, (void*)0, 0);

	shared_stuff = (struct shared_mem_st*)shared_memory;

	//todo:creatr 3 signal
	sem_queue=sem_open("queue_mutex",O_CREAT,0644,1);
	sem_queue_empty=sem_open("queue_empty",O_CREAT,0644,10);
	sem_queue_full=sem_open("queue_full",O_CREAT,0644,0);
	

	
	shared_stuff->line_write = 0;
	shared_stuff->line_read = 0;


	//read
	while(1) {
		printf("Enter text('quit' for exit):");
		gets(key_line);

		if(strcmp(shared_stuff->buffer[shared_stuff->line_write],"quit")==0) {
			break;
		}

		//todo:put in buffer with signal
	//	sem_queue_empty=sem_open(argv[1],0);
		sem_wait(sem_queue_empty);
		       sem_wait(sem_queue);
		            shared_memory = shared_stuff->buffer[shared_stuff->line_write];
		        sem_post(sem_queue);
		sem_post(sem_queue_full);

	}
	             //todo:release signals, end connect M, delete shared area
	              sem_unlink("sem_queue_empty");
	              sem_unlink("sem_queue_full");
	              sem_unlink("sem_queue");

	              shmdt("shm_buf");

	              return 0;
}
