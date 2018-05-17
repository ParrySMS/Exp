#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include <sys/shm.h>

#include  "shm_com_sem.h"

int main() {
	void *shared_memory = (void *)0;
	struct shared_mem_st *shared_stuff;

	int shmid;
	int num_read;
	pid_t fork_result;
	sem_t *sem_queue,*sem_queue_empty,*sem_queue_full;

	//todo: get shared memory,put in
	if ((shm_id=shmget(IPC_PRIVATE, 1024, 0666)) == -1) {
		perror("shmget");
		exit(-1);
	}


	shared_memory = shmat(shm_id, 0, 0);
	shared_stuff = (struct shared_mem_st *) shared_memory;
	//todo: get 3 signal
	sem_queue_empty=sem_open(argv[1],0);
	sem_queue=sem_open(argv[1],0);
	sem_queue_full=sem_open(argv[1],0);

	fork_result = fork();
	if(fotk_result == -1) {
		fprintf(stderr,"Fork failure\n");
	}

	if(fork_result == 0) {
		//�ӽ���
		while(1) {
			//todo �ź�����������ӡ���������Լ����̺ţ����� quit �˳�
			if(strcmp(shared_stuff->buffer[shared_stuff->line_write],"quit")==0) {
				break;
			}

			sem_wait(sem_queue_full);
			sleep(1);
			printf("Waiting...\n");
			printf("wait--sq-empty:%d  %s \n",sem_getvalue(sem_queue_empty,&val,*shared_memory);
			       sem_wait(sem_queue_empty);
		}
		//todo �ͷ��ź���
		//todo:release signals, end connect M, delete shared area
		sem_unlink("sem_queue_empty");
		sem_unlink("sem_queue_full");
		sem_unlink("sem_queue");

		shmdt("shm_buf");


	} else { //�����̣����ӽ�������
		while(1) {
			//todo �ź�����������ӡ���������Լ����̺ţ����� quit �˳�
			if(strcmp(shared_stuff->buffer[shared_stuff->line_write],"quit")==0) {
				break;
			}
			sem_wait(sem_queue_full);
			sleep(1);
			printf("Waiting...\n");
			printf("wait--sq-empty:%d  %s \n",sem_getvalue(sem_queue_empty,&val,*shared_memory);
			       sem_wait(sem_queue_empty);
		}
		//todo �ͷ��ź���   //todo:release signals, end connect M, delete shared area
		sem_unlink("sem_queue_empty");
		sem_unlink("sem_queue_full");
		sem_unlink("sem_queue");

		shmdt("shm_buf");
	}
	exit(EXIT_SUCCESS);

}
